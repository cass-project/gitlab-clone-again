<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {

        try {
            $profileId = (int) $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            return $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $this->profileExtendedFormatter->format($profile)
                ])
                ->build();
        } catch (ProfileNotFoundException $e) {
            return $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
                ->build();
        }
    }
}