<?php

namespace Example\Models;

/**
 * Contains all information related to a single comment.
 */
class Comment extends BaseModel
{
    /**
     * Comment ID.
     *
     * @var int|null
     */
    private $id;

    /**
     * Comment's author name.
     *
     * @var string
     */
    private $name;

    /**
     * Comment message.
     *
     * @var string
     */
    private $text;

    /**
     * Returns ID.
     *
     * The comment's unique ID.
     *
     * @return int|null
     *   Comment's unique ID.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Sets ID.
     *
     * The comment's unique ID.
     *
     * @param int $id
     *   Comment's unique ID.
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns comment's author name.
     *
     * @return string
     *   Comment's author name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets comment's author name.
     *
     * @param string $name
     *   Comment's author name.
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns comment's message.
     *
     * @return string
     *   Comment's message.
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Sets comment's message.
     *
     * @param string $text
     *   Comment's message.
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        $json['id'] = $this->id;
        $json['name'] = $this->name;
        $json['text'] = $this->text;

        return \array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
