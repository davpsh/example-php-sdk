<?php

namespace Example\Tests\Models;

use Example\Models\Comment;
use PHPUnit\Framework\TestCase;

/**
 * Test case covers comments API calls.
 *
 * @coversDefaultClass \Example\Models\Comment
 */
class CommentTest extends TestCase
{
    public function testModel()
    {
        $id = random_int(0, 100);
        $name = random_bytes(8);
        $text = random_bytes(20);

        $expected = \array_filter(
            \array_combine(
                ['id', 'name', 'text'],
                [$id, $name, $text]
            )
        );

        $model = new Comment();
        foreach ($expected as $property => $value) {
            $method = 'set' . ucfirst($property);
            $model->{$method}($value);
        }

        self::assertEquals($expected, $model->jsonSerialize());

        foreach ($expected as $property => $value) {
            $method = 'get' . ucfirst($property);
            self::assertEquals($value, $model->{$method}());
        }
    }
}
