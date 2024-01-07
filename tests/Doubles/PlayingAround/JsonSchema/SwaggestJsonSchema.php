<?php

declare(strict_types=1);

namespace Smoothie\Tests\SchemaInterpreter\Unit;

use Smoothie\Tests\SchemaInterpreter\BasicTestCase;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\Schema;

/**
 * @group unit
 * @group unit-dummy
 */
class SwaggestJsonSchema extends BasicTestCase
{
    public function testJsonResume(): void
    {
        $examplePath = $this->getJsonResumeDirectory('example_invalid.json');
        //        $examplePath = $this->getJsonResumeDirectory('example_valid.json');
        $schemaPath = $this->getJsonResumeDirectory('schema.json');

        $pathToExample = realpath($examplePath);
        $pathToSchema = realpath($schemaPath);

        $this->validate($pathToExample, $pathToSchema);
    }

    public function testOpenApiV20(): void
    {
        //        $examplePath = $this->getOpenApiDirectory('v2.0/example_invalid.json');
        $examplePath = $this->getOpenApiDirectory('v2.0/example_valid.json');
        $schemaPath = $this->getOpenApiDirectory('v2.0/schema.json');

        $pathToExample = realpath($examplePath);
        $pathToSchema = realpath($schemaPath);

        $this->validate($pathToExample, $pathToSchema);
    }

    public function testOpenApiV30(): void
    {
        //        $examplePath = $this->getOpenApiDirectory('v3.0/example_invalid.json');
        $examplePath = $this->getOpenApiDirectory('v3.0/example_valid.json');
        $schemaPath = $this->getOpenApiDirectory('v3.0/schema.json');

        $pathToExample = realpath($examplePath);
        $pathToSchema = realpath($schemaPath);

        $this->validate($pathToExample, $pathToSchema);
    }

    public function testOpenApiV31(): void
    {
        //        $examplePath = $this->getOpenApiDirectory('v3.1/example_invalid.json');
        $examplePath = $this->getOpenApiDirectory('v3.1/example_valid.json');
        $schemaPath = $this->getOpenApiDirectory('v3.1/schema.json');
        $data = json_decode(file_get_contents($examplePath));

        $pathToExample = realpath($examplePath);
        $pathToSchema = realpath($schemaPath);

        $this->validate($pathToExample, $pathToSchema);
    }

    private function validate(string $pathToExample, string $pathToSchema): void
    {
        $schema = Schema::import($pathToSchema);

        $data = json_decode(file_get_contents($pathToExample));

        $options = new Context();

        try {
            $result = $schema->in($data, $options);
        } catch (\Throwable $exception) {
            $woot = '';
            self::assertTrue(false);

            return;
        }

        //        $this->isValid($result);
        $woot = '';
        self::assertTrue(true);
    }
}
