<?php
namespace ZEA2\Platform\Bundles\Swagger\APIDocs;

use Cocur\Chain\Chain;
use Symfony\Component\Yaml\Yaml;

class APIDocsBuilder
{
    /**
     * @var APIDocsBuilderRequest
     */
    private $apiDocsBuildRequest;

    public function __construct(APIDocsBuilderRequest $apiDocsBuildRequest)
    {
        $this->apiDocsBuildRequest = $apiDocsBuildRequest;
    }

    public function getApiDocsBuildRequest()
    {
        return $this->apiDocsBuildRequest;
    }

    public function build() {
        $request = $this->apiDocsBuildRequest;

        $result = Chain::create($request->getDirectories())
            ->filter(function /* list only existing directories */ ($directory) {
                return is_dir($directory);
            })
            ->map(function /* list files to merge */ ($directory) {
                $definitions = Chain::create(scandir($directory))
                    ->filter(function($input) use ($directory) {
                        return $input !== '.' && $input !== '..' && is_dir("{$directory}/{$input}");
                    })
                    ->map(function($prefix) use ($directory) {
                        $subDirectory = "{$directory}/{$prefix}";

                        return [
                            'prefix' => $prefix,
                            'files' => $this->recursiveListYAMLFiles($subDirectory)
                        ];
                    })
                    ->array
                ;

                if(file_exists($globalFile = "{$directory}/global.yml")) {
                    $definitions[] = [
                        'prefix' => null,
                        'files' => [
                            $globalFile
                        ]
                    ];
                }

                return $definitions;
            })
            ->map(function /* read yml files to arrays */ ($definitions) {
                $config = [];

                foreach($definitions as $definition) {
                    $prefix = $definition['prefix'];
                    $files = $definition['files'];

                    $ymlParsedFiles = Chain::create($files)
                        ->map(function($file) {
                            return Yaml::parse(file_get_contents($file));
                        })
                        ->reduce(function($carry, $item) {
                            return array_merge_recursive($carry, $item);
                        }, [])
                    ;

                    if($prefix === null) {
                        $config = $config + $ymlParsedFiles;
                    }else{
                        if(!(isset($config[$prefix]))) {
                            $config[$prefix] = [];
                        }

                        $config = array_merge_recursive($config, [$prefix => $ymlParsedFiles]);
                    }
                }

                return $config;
            })
            ->reduce(function /* merge all bundle configs into swagger.json */ ($config, $yml) {
                return array_merge_recursive($config, $yml);
            }, [
                'paths' => [],
                'definitions' => [],
                'responses' => []
            ])
        ;

        if(! count($result['paths'])) unset($result['paths']);
        if(! count($result['definitions'])) unset($result['definitions']);
        if(! count($result['responses'])) unset($result['responses']);

        return $result;
    }

    private function recursiveListYAMLFiles($directory) {
        $files = [];

        foreach(scandir($directory) as $input) {
            switch($input) {
                case '.':
                case '..':
                    break;

                case is_dir($subDirectory = "{$directory}/{$input}"):
                    $files = array_merge($files, $this->recursiveListYAMLFiles($subDirectory));
                    break;

                case is_file(($file = "{$directory}/{$input}")) && preg_match('/\.yml$/', $file):
                    $files[] = $file;
                    break;
            }
        }

        return $files;
    }
}