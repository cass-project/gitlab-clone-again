<?php
namespace Domain\IM\Query\Source;

interface Source
{
    public static function getCode(): string;
    public static function createFromParams(array $params): Source;
    public function getMongoDBCollectionName(): string;
}