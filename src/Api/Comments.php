<?php

namespace Example\Api;

use Example\Models\Comment;

/**
 * Comments API.
 */
class Comments extends BaseApi
{
    /**
     * Filter fields.
     *
     * @param array $fields
     *   Fields with values.
     *
     * @return array
     *   Filtered fields and values.
     */
    protected function filterFields(array $fields): array
    {
        $allowed = \array_flip(['text', 'name']);

        return \array_filter(\array_intersect_key($fields, $allowed));
    }

    /**
     * Create comment.
     *
     * @param array $fields
     *   Fields with values to create.
     *
     * @return \Example\Models\Comment
     *   Comment model instance.
     */
    public function create(array $fields): Comment
    {
        $response = $this->request('post', '/comment', [], $this->filterFields($fields));

        return $this->mapResponseToModel($response, Comment::class);
    }

    /**
     * Update comment.
     *
     * @param int $id
     *   Comment ID.
     * @param array $fields
     *   Fields with values to create.
     *
     * @return \Example\Models\Comment
     *   Comment model instance.
     */
    public function update(int $id, array $fields): Comment
    {
        $response = $this->request('put', "/comment/$id", [], $this->filterFields($fields));

        return $this->mapResponseToModel($response, Comment::class);
    }

    /**
     * Get comments list.
     *
     * @param int $limit
     *   Limits to select.
     * @param int $offset
     *   Offset to select.
     *
     * @return \Example\Models\Comment[]
     *   Comment model instances.
     */
    public function list($limit = 100, $offset = 0): array
    {
        $response = $this->request('get', '/comments', ['limit' => $limit, 'offset' => $offset]);

        return $this->mapResponseToMultipleModels($response, Comment::class);
    }
}
