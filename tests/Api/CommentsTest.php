<?php

namespace Example\Tests\Api;

use Example\Api\Comments as CommentsApi;
use Example\Http\Response;
use Example\Models\Comment;
use PHPUnit\Framework\TestCase;

/**
 * Test case covers comments API calls.
 *
 * @coversDefaultClass \Example\Api\Comments
 */
class CommentsTest extends TestCase
{
    /**
     * @covers ::list
     */
    public function testListComments()
    {
        $data = [];

        $stub = $this->createPartialMock(CommentsApi::class, ['request']);
        $stub->expects($this->once())
          ->method('request')
          ->with('get', '/comments')
          ->willReturnCallback(function () use (&$data) {
              $content = file_get_contents(__DIR__ . '/../data/comments.json');
              $json = \json_decode($content, true);
              $data = $json['items'] ?? [];

              return new Response(200, $content);
          });
        $comments = $stub->list();

        $expected = [];
        foreach ($data as $row) {
            $expected[] = $stub->convertObjectToModel((object) $row, Comment::class);
        }

        self::assertIsArray($comments);
        self::assertEquals($expected, $comments);
    }

    /**
     * @covers ::create
     */
    public function testCommentCreate()
    {
        $expected = null;

        $stub = $this->createPartialMock(CommentsApi::class, ['request']);
        $stub->expects($this->once())
          ->method('request')
          ->with('post', '/comment')
          ->willReturnCallback(function () use (&$expected) {
              $content = file_get_contents(__DIR__ . '/../data/comment.json');
              $expected = \json_decode($content, true);

              return new Response(200, $content);
          });
        $comment = $stub->create(['name' => 'John Doe', 'text' => 'Test message']);
        $expected = $stub->convertObjectToModel((object) $expected, Comment::class);

        self::assertEquals($expected, $comment);
    }

    /**
     * @covers ::update
     */
    public function testCommentUpdate()
    {
        $expected = null;
        $commentId = 1;
        $commentFields = ['name' => 'John', 'text' => 'Test'];

        $stub = $this->createPartialMock(CommentsApi::class, ['request']);
        $stub->expects($this->once())
          ->method('request')
          ->with('put', "/comment/$commentId")
          ->willReturnCallback(function () use (&$expected, $commentFields) {
              $content = file_get_contents(__DIR__ . '/../data/comment.json');
              $data = \json_decode($content, true);
              $expected = \array_replace($commentFields, $data);

              return new Response(200, $content);
          });
        $comment = $stub->update(1, $commentFields);
        $expected = $stub->convertObjectToModel((object) $expected, Comment::class);

        self::assertEquals($expected, $comment);
    }
}
