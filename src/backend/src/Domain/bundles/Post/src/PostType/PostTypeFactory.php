<?php
namespace CASS\Domain\Bundles\Post\PostType;

use CASS\Domain\Bundles\Post\Exception\UnknownPostTypeException;
use CASS\Domain\Bundles\Post\PostType\Types\DefaultPostType;
use CASS\Domain\Bundles\Post\PostType\Types\DiscussionPostType;

final class PostTypeFactory
{
    public function getPostTypeDefinitions(): array
    {
        return [
            [
                'int' => DefaultPostType::CODE_INT,
                'string' => DefaultPostType::CODE_STRING,
            ],
            [
                'int' => DiscussionPostType::CODE_INT,
                'string' => DiscussionPostType::CODE_STRING,
            ]
        ];
    }

    public function createPostTypeByIntCode(int $intCode): PostType
    {
        switch($intCode) {
            default:
                throw new UnknownPostTypeException(sprintf('Unknown post type with code `%s`', $intCode));

            case DefaultPostType::CODE_INT:
                return new DefaultPostType();

            case DiscussionPostType::CODE_INT:
                return new DiscussionPostType();
        }
    }

    public function createPostTypeByStringCode(string $stringCode): PostType
    {
        switch($stringCode) {
            default:
                throw new UnknownPostTypeException(sprintf('Unknown post type with code `%s`', $stringCode));

            case DefaultPostType::CODE_STRING:
                return new DefaultPostType();

            case DiscussionPostType::CODE_STRING:
                return new DiscussionPostType();
        }
    }
}