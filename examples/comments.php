<?php

use Example\ExampleClient;

require_once '../vendor/autoload.php';

try {
    $client = new ExampleClient();
    $comment = $client->comments()->create(['text' => 'Test comment', 'name' => 'User XXXX']);
    print_r($comment->jsonSerialize());

    $comments = $client->comments()->list();
    print_r($comments);
} catch (\Throwable $exception) {
    print 'API Exception: ' . $exception->getCode() . ' ' . $exception->getMessage();
}
