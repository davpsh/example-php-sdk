<?php

namespace Example\Tests\Api;

use Example\Api\BaseApi;
use Example\Models\ModelInterface;
use PHPUnit\Framework\TestCase;

/**
 * Test case covers base API calls.
 *
 * @coversDefaultClass \Example\Api\BaseApi
 */
class BaseApiTest extends TestCase
{
    /**
     * @covers ::absoluteUrl
     *
     * @dataProvider absoluteUrlProvider
     */
    public function testAbsoluteUrlGeneration($expected, $uri)
    {
        $stub = $this->getMockForAbstractClass(BaseApi::class, [], '', false);
        $actual = $stub->absoluteUrl($uri);

        self::assertEquals($expected, $actual);
    }

    public function absoluteUrlProvider()
    {
        return [
          ['http://example.com/test', '/test'],
          ['http://example.com/test', 'test'],
        ];
    }

    /**
     * @covers ::getJsonMapper
     * @covers ::convertObjectToModel
     * @covers ::mapResponseToModel
     * @covers ::mapResponseToMultipleModels
     */
    public function testJsonMapper()
    {
        $bytes = random_bytes(12);
        $object = new \stdClass();
        $object->value = $bytes;
        $stub = $this->getMockForAbstractClass(BaseApi::class, [], '', false);

        $model = new class implements ModelInterface {
            private $value;

            public function setValue($value)
            {
                $this->value = $value;
            }

            public function getValue()
            {
                return $this->value;
            }

            public function jsonSerialize()
            {
                return ['value' => $this->value];
            }
        };

        $actual = $stub->convertObjectToModel($object, \get_class($model));

        $expected = new $model();
        $expected->setValue($bytes);

        self::assertArrayHasKey(ModelInterface::class, \class_implements($actual));
        self::assertEquals($expected->jsonSerialize(), $actual->jsonSerialize());
    }
}
