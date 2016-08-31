<?php
namespace Domain\Theme\Middleware\Request;

use CASS\Application\REST\Service\JSONSchema;
use CASS\Application\REST\Request\Params\SchemaParams;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Parameters\CreateThemeParameters;
use Domain\Theme\ThemeBundle;

class CreateThemeRequest extends SchemaParams
{
    public function getParameters(): CreateThemeParameters {
        $data = $this->getData();

        $parentId = $data['parent_id'] ?? null;

        return new CreateThemeParameters(
            $data['title'],
            $data['description'],
            $data['preview'] ?? Theme::DEFAULT_PREVIEW,
            $parentId,
            $data['force_id'] ?? null,
            $data['url'] ?? null
        );
    }

    protected function getSchema(): JSONSchema {
        return self::getSchemaService()->getSchema(ThemeBundle::class, './definitions/request/CreateThemeRequest.yml');
    }
}