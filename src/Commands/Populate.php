<?php

namespace Meops\Populate\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Meops\Populate\Utils\FileUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Finder\SplFileInfo;

#[AsCommand(name: 'db:populate')]
class Populate extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'db:populate
        {class : The class to populate}
        {count? : The number of records to create}
        {--o|override=* : Override factory definition fields}';

    /**
     * Array of field values overrides to pass to the factory
     */
    private array $overrides = [];

    public function handle(): int
    {
        $this->overrides = [];

        if($this->option('override')) {
            $this->overrides = $this->overridesToArray($this->option('override'));
        }

        $class = $this->argument('class');

        if(!class_exists($class)) {
            $matches = $this->discoverModels($class);

            if (!count($matches)) {
                $this->fail('Class ' . $this->argument('class') .  ' not found');
            }

            if (count($matches) > 1) {
                $class = $this->choice('Ambiguous model name passed. Which model would you like to populate?', $matches);
            } else {
                $class = $matches[0];
            }
        }

        $this->createRecords($class, $this->argument('count') ?? 1);

        return(self::SUCCESS);
    }

    /**
     * Discover models within the configured directory
     *
     * @param string|null $name The name of a model to search for
     * @return array<string> A list of model class names
     *
     */
    private function discoverModels(?string $name = null): array
    {
        $dir = config('laravel-populate.models_dir', app_path('Models'));

        $models = collect(File::allFiles($dir))
            ->map(function (SplFileInfo $file) {
                return FileUtil::getClassFqn($file);
            })
            ->filter(function (string $class) use ($name) {
                if($name && !str_contains($class, $name)) {
                    return false;
                }
                if(!class_exists($class)) {
                    return false;
                }
                $reflection = new \ReflectionClass($class);
                return $reflection->isSubclassOf(Model::class) &&
                    !$reflection->isAbstract();
            });

        return $models->values()->toArray();
    }

    private function createRecords(string $class, int $count): void
    {
        $this->line("Creating {$count} records for {$class}...");

        try {
            $factory = $class::factory();
        } catch (\Throwable) {
            $this->fail('Factory not found for ' . $class);
        }

        $createdCount = $factory
                            ->count($count)
                            ->create($this->overrides)
                            ->count();

        $records = $createdCount > 1 ? 'records' : 'record';

        $this->info("Populated database with {$createdCount} `{$class}` {$records}");
    }
    
    private function overridesToArray(array $overrides): array
    {
        return collect($overrides)
            ->mapWithKeys(function ($override) {
                if (!str_contains($override, '=')) {
                    $this->fail('Invalid field override format: ' . $override);
                }
                $parts = explode('=', $override);
                return [$parts[0] => $parts[1]];
            })
            ->toArray();
    }
}
