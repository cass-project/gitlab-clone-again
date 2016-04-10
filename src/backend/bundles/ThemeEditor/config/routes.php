<?php
namespace ThemeEditor;

use ThemeEditor\Middleware\ThemeEditorCRUDMiddleware;
use Zend\Expressive\Application;

return function(Application $app, string $prefix) {
    $app->put(
        sprintf('%s/protected/host-admin/theme-editor/entity/{command:create}', $prefix),
        ThemeEditorCRUDMiddleware::class,
        'theme-editor-create'
    );

    $app->post(
        sprintf('%s/protected/host-admin/theme-editor/entity/{command:update}/{themeId}', $prefix),
        ThemeEditorCRUDMiddleware::class,
        'theme-editor-update'
    );

    $app->post(
        sprintf('%s/protected/host-admin/theme-editor/entity/{command:move}/{themeId}/under/{parentThemeId}/in-position/{position}', $prefix),
        ThemeEditorCRUDMiddleware::class,
        'theme-editor-move'
    );

    $app->delete(
        sprintf('%s/protected/host-admin/theme-editor/entity/{command:delete}/{themeId}', $prefix),
        ThemeEditorCRUDMiddleware::class,
        'theme-editor-delete'
    );

    $app->get(
        sprintf('%s/protected/host-admin/theme-editor/{command:read}/entity/{themeId}', $prefix),
        ThemeEditorCRUDMiddleware::class,
        'theme-editor-read-entity'
    );

    $app->get(
        sprintf('%s/protected/host-admin/theme-editor/{command:read}/{mode:entities}/', $prefix),
        ThemeEditorCRUDMiddleware::class,
        'theme-editor-read'
    );

    $app->get(
        sprintf('%s/protected/host-admin/theme-editor/{command:read}/{mode:entities-tree}/', $prefix),
        ThemeEditorCRUDMiddleware::class,
        'theme-editor-read-tree'
    );
};