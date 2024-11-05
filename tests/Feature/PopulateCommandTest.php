<?php

namespace Meops\Populate\Tests\Feature;

use Meops\Populate\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PopulateCommandTest extends TestCase
{
    private string $command = 'db:populate';
    private string $modelFqn = 'Meops\\Populate\\Tests\\Models\\User';

    #[Test]
    public function canCreateSingleRecord(): void
    {
        $this->artisan($this->command, [
            'class' => $this->modelFqn,
        ])
            ->expectsOutput("Populated database with 1 `{$this->modelFqn}` record")
            ->assertExitCode(0);

        $this->assertDatabaseCount($this->modelFqn, 1);
    }

    #[Test]
    public function canCreateRecordsWithCount(): void
    {
        $this->artisan($this->command, [
            'class' => $this->modelFqn,
            'count' => 6
        ])
            ->expectsOutput("Populated database with 6 `{$this->modelFqn}` records")
            ->assertExitCode(0);

        $this->assertDatabaseCount($this->modelFqn, 6);
    }
}