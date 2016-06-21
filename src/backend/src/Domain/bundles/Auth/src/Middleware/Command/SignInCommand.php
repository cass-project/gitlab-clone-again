<?php
namespace Domain\Auth\Middleware\Command;

use Application\Frontline\FrontlineScript;
use Application\Frontline\Service\FrontlineService\IncludeFilter;
use Application\REST\Response\ResponseBuilder;
use Domain\Auth\Formatter\SignInFormatter;
use Domain\Auth\Middleware\Request\SignInRequest;
use Domain\Auth\Exception\InvalidCredentialsException;
use Domain\Account\Exception\AccountNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SignInCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
        try {
            $request = new SignInRequest($request);
            $account = $this->authService->signIn($request->getParameters());
            $frontline = $this->frontlineService->fetch(new IncludeFilter([
                FrontlineScript::TAG_IS_AUTHENTICATED
            ]));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson((new SignInFormatter())->format($account, $frontline))
            ;
        }catch(AccountNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }catch(InvalidCredentialsException $e) {
            $responseBuilder
                ->setStatusNotAllowed()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}