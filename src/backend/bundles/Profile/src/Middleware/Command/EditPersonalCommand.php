<?php
namespace Profile\Middleware\Command;

use Common\Exception\PermissionsDeniedException;
use Profile\Middleware\Request\EditPersonalRequest;
use Profile\Middleware\Parameters\EditPersonalParameters;
use Psr\Http\Message\ServerRequestInterface;

class EditPersonalCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $profileId = $this->validateProfileId($request->getAttribute('profileId'));
        $profile = $this->profileService->getProfileById($profileId);

        if(!$this->currentAccountService->getCurrentAccount()->isYoursProfile($profile)) {
            throw new PermissionsDeniedException("You're not an owner of this profiles");
        }

        $request = new EditPersonalRequest($request);
        $params = $request->getParameters(); /** @var EditPersonalParameters $params */

        $this->profileService->updatePersonalData($profileId, $params);

        return [];
    }
}