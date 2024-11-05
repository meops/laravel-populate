<?php

namespace Meops\Populate\Utils;

use Symfony\Component\Finder\SplFileInfo;

class FileUtil
{
    /**
     * Parse the namespace from a PHP file
     */
    public static function extractNamespace(string $path): string
    {
        if (pathinfo($path, PATHINFO_EXTENSION) !== 'php') {
            return '';
        }
        $handle = fopen($path, 'r');
        if ($handle) {
            while (($line = fgets($handle))) {
                if (str_starts_with($line, 'namespace')) {
                    $namespace = rtrim(
                        trim(explode(' ', $line)[1]),
                        ';'
                    );
                    break;
                }
            }
            fclose($handle);
        }
        return $namespace ?? '';
    }

    public static function getClassFqn(SplFileInfo $file): string
    {
        $ns = self::extractNamespace($file->getPathName());
        return str_replace(
            '.' . $file->getExtension(),
            '',
            $ns . '\\' . $file->getFilename()
        );
    }
}
