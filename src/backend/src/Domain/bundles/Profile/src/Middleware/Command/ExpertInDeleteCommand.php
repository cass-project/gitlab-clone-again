<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\NotOwnProfileException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExpertInDeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
        $profileId = (int) $request->getAttribute('profileId');

        if(! $this->validateIsOwnProfile($profileId)) {
            throw new NotOwnProfileException(sprintf('Domain\Profile with ID `%s` is not yours', $profileId));
        }

        $expertInParameters = explode(',',$request->getAttribute('theme_ids'));

        $this->profileService->deleteExpertsInParameters($profileId, $expertInParameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}