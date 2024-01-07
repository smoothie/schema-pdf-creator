<?php

declare(strict_types=1);

namespace Smoothie\Tests\SchemaInterpreter\Unit;

use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\Validator;
use Smoothie\Tests\SchemaInterpreter\BasicTestCase;

/**
 * @group unit
 * @group unit-dummy
 */
class OpisJsonSchema extends BasicTestCase
{
    public function testJsonResume(): void
    {
        //        $examplePath = $this->getJsonResumeDirectory('example_invalid.json');
        $examplePath = $this->getJsonResumeDirectory('example_valid.json');
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
        $validator = new Validator();

        $validator->resolver()->registerFile(id: 'file:someSchema', file: 'file://'.$pathToSchema);

        $data = json_decode(file_get_contents($pathToExample));

        $result = $validator->validate(
            data: $data,
            schema: 'file:someSchema',
        );

        $this->isValid($result);
    }

    private function isValid(ValidationResult $result): void
    {
        if ($result->isValid()) {
            self::assertTrue(true);

            return;
        }

        print_r((new ErrorFormatter())->format($result->error()));

        self::assertTrue(false);
    }
}
