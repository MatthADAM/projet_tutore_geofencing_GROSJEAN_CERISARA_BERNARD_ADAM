<?php

namespace App\Application\Actions\Api\Users;

use App\Domain\User;
use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class UsersAction extends Action {
    /**
    * @var users
    */
    protected $users;
    
    /**
    * @param LoggerInterface $logger
    * @param users  $users
    */
    public function __construct(LoggerInterface $logger, User $users)
    {
        parent::__construct($logger);
        $this->users = $users;
    }
}

?>