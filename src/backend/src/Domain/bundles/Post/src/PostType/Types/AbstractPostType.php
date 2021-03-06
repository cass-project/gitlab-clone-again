<?php
namespace CASS\Domain\Bundles\Post\PostType\Types;

use CASS\Domain\Bundles\Post\PostType\PostType;

abstract class AbstractPostType implements PostType
{
    public function toJSON(): array
    {
        return [
            'int' => $this->getIntCode(),
            'string' => $this->getStringCode(),
        ];
    }
}