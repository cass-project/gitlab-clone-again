<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\Gender;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Profile\Middleware\Request\SetGenderRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

class SetGenderCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response
    {
        try {
            $gender = $this->profileService->setGender($request->getAttribute('profileId'), Gender::createFromStringCode(
                (new SetGenderRequest($request))->getParameters()->getGenderStringCode()
            ));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'gender' => $gender->toJSON()
                ]);
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}