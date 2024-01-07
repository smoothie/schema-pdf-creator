<?php

declare(strict_types=1);

namespace Smoothie\Tests\SchemaInterpreter\Unit;

use JsonSchema\Validator;
use Smoothie\Tests\SchemaInterpreter\BasicTestCase;

/**
 * @group unit
 * @group unit-dummy
 */
class JustinRainbowJsonSchemaTest extends BasicTestCase
{
    public function testJsonResume(): void
    {
        $examplePath = $this->getJsonResumeDirectory('example_invalid.json');
        //        $examplePath = $this->getJsonResumeDirectory('example_valid.json');
        $schemaPath = $this->getJsonResumeDirectory('schema.json');
        $data = json_decode(file_get_contents($examplePath));

        $pathToSchema = realpath($schemaPath);

        $this->validate($data, $pathToSchema);
    }

    public function testOpenApiV20(): void
    {
        //        $examplePath = $this->getOpenApiDirectory('v2.0/example_invalid.json');
        $examplePath = $this->getOpenApiDirectory('v2.0/example_valid.json');
        $schemaPath = $this->getOpenApiDirectory('v2.0/schema.json');
        $data = json_decode(file_get_contents($examplePath));

        $pathToSchema = realpath($schemaPath);

        $this->validate($data, $pathToSchema);
    }

    public function testOpenApiV30(): void
    {
        //        $examplePath = $this->getOpenApiDirectory('v3.0/example_invalid.json');
        $examplePath = $this->getOpenApiDirectory('v3.0/example_valid.json');
        $schemaPath = $this->getOpenApiDirectory('v3.0/schema.json');
        $data = json_decode(file_get_contents($examplePath));

        // Validate
        $pathToSchema = realpath($schemaPath);

        $this->validate($data, $pathToSchema);
    }

    public function testOpenApiV31(): void
    {
        //        $examplePath = $this->getOpenApiDirectory('v3.1/example_invalid.json');
        $examplePath = $this->getOpenApiDirectory('v3.1/example_valid.json');
        $schemaPath = $this->getOpenApiDirectory('v3.1/schema.json');
        $data = json_decode(file_get_contents($examplePath));

        // Validate
        $pathToSchema = realpath($schemaPath);

        $this->validate($data, $pathToSchema);
    }

    private function validate(\stdClass|array $data, string $pathToSchema): void
    {
        $validator = new Validator();
        $validator->validate(
            value: $data,
            schema: ['$ref' => 'file://'.$pathToSchema],
            //            checkMode: Constraint::CHECK_MODE_COERCE_TYPES,
        );

        $this->isValid($validator);
    }

    private function isValid(Validator $validator): void
    {
        if ($validator->isValid()) {
            self::assertTrue(true);

            return;
        }

        foreach ($validator->getErrors() as $error) {
            printf("[%s] %s\n", $error['property'], $error['message']);
        }

        self::assertTrue(false);
    }
}
