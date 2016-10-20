<?php
namespace CASS\Chat\Middleware\Command;

use CASS\Chat\Service\MessageService;
use CASS\Chat\Service\RoomService;
use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

abstract class  Command implements \CASS\Application\Command\Command
{

    protected $profileService;
    protected $messageService;
    protected $currentAccountService;
    protected $roomService;

    public function __construct(
        ProfileService $profileService,
        MessageService $messageService,
        CurrentAccountService $currentAccountService,
        RoomService $roomService)
    {
        $this->profileService = $profileService;
        $this->messageService = $messageService;
        $this->currentAccountService = $currentAccountService;
        $this->roomService = $roomService;
    }

}