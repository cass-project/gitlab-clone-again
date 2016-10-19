<?php

namespace CASS\Chat\Middleware\Command;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class CreateRoomCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {

            $name = $request->getBody()->getContents()['name'];

            print_r("hellow".$name);
            die();
        } catch(\Exception $e) {

        }
    }
}