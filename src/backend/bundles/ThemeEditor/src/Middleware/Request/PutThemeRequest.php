<?php
namespace ThemeEditor\Middleware\Request;

use Common\Service\JSONSchema;
use Common\Tools\RequestParams\Param;
use Common\Tools\RequestParams\SchemaParams;
use Data\Repository\Theme\Parameters\CreateThemeParameters;
use ThemeEditor\ThemeEditorBundle;

class PutThemeRequest extends SchemaParams
{
    public function getParameters()
    {
        $data = $this->getData();

        $title = new Param($data, 'title', true);
        $parentId = new Param($data, 'parent_id');
        $position = new Param($data, 'position');

        return new CreateThemeParameters($title, $parentId, $position);
    }

    protected function getSchema(): JSONSchema
    {
        return self::getSchemaService()->getSchema(ThemeEditorBundle::class, './definitions/request/PUTThemeRequest.yml');
    }

}