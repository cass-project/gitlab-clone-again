<?php
namespace Profile\Middleware\Command;

use Auth\Service\CurrentAccountService;
use Profile\Service\ProfileService;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

abstract class Command
{
    const COMMAND_CREATE = 'create';
    const COMMAND_DELETE = 'delete';
    const COMMAND_GET = 'get';
    const COMMAND_GREETINGS_AS = 'greetings-as';
    const COMMAND_IMAGE_UPLOAD = 'image-upload';
    const COMMAND_UPDATE = 'update';

    /** @var ProfileService */
    protected $profileService;

    /** @var CurrentAccountService */
    protected $currentAccountService;

    private function setProfileService(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function setCurrentAccountService($currentAccountService)
    {
        $this->currentAccountService = $currentAccountService;
    }

    public static function factory(ServerRequestInterface $request, ProfileService $profileService, CurrentAccountService $currentAccountService): Command
    {
        $command = self::factoryCommand($request->getAttribute('command'));
        $command->setProfileService($profileService);
        $command->setCurrentAccountService($currentAccountService);

        return $command;
    }

    private static function factoryCommand(string $command) {
        switch ($command) {
            default:
                throw new CommandNotFoundException(sprintf("Command %s::%s not found", self::class, $command));

            case self::COMMAND_CREATE:
                return new CreateCommand();

            case self::COMMAND_DELETE:
                return new DeleteCommand();

            case self::COMMAND_GET:
                return new GetCommand();

            case self::COMMAND_GREETINGS_AS:
                return new GreetingsAsCommand();

            case self::COMMAND_IMAGE_UPLOAD:
                return new ImageUploadCommand();

            case self::COMMAND_UPDATE:
                return new UpdateCommand();
        }
    }

    abstract public function run(ServerRequestInterface $request);

    protected function validateProfileId($input): int
    {
        $isInteger = filter_var($input, FILTER_VALIDATE_INT);
        $isMoreThanZero = (int) $input > 0;

        if(!($isInteger && $isMoreThanZero)) {
            throw new \InvalidArgumentException('Invalid profileId');
        }

        return (int) $input;
    }
}
