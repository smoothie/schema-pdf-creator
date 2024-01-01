<?php

declare(strict_types=1);

namespace Smoothie\Tests\SchemaPdfCreator;

use PHPUnit\Framework\TestCase;

class BasicTestCase extends TestCase
{
    public function getTemplateDoublesDirectory(string $path = ''): string
    {
        return __DIR__.'/Doubles/Files/Templates/'.$path;
    }

    public function getTmpDirectory(string $path = ''): string
    {
        return sys_get_temp_dir().$path;
    }
}
