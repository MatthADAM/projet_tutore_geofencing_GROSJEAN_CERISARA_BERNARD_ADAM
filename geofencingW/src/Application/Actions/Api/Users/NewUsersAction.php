<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Users;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User;

class NewUsersAction extends UsersAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $user = new User;
        $user->email = $data["email"];
        $user->password = $data["password"];
        $user->admin = $data["admin"];
        $user->save();
        return $this->respondWithData($user);
    }
}

?>