<?php

declare(strict_types=1);

namespace Smoothie\Tests\SchemaInterpreter;

use PHPUnit\Framework\TestCase;

class BasicTestCase extends TestCase
{
    public function getJsonResumeDirectory(string $path = ''): string
    {
        return \dirname(__FILE__, 2).'/Doubles/Files/JsonResume/'.$path;
    }

    public function getOpenApiDirectory(string $path = ''): string
    {
        return \dirname(__FILE__, 2).'/Doubles/Files/OpenApi/'.$path;
    }

    public function getTmpDirectory(string $path = ''): string
    {
        return sys_get_temp_dir().$path;
    }
}
