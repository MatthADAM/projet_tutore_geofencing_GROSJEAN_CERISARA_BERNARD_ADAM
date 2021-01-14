<?php

declare(strict_types=1);

namespace App\Application\Actions\Api\Users;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User;

class PutUsersAction extends UsersAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $userId = (int) $this->resolveArg('id');
        $users = $this->users->find($userId);
        $users->email = $data["email"];
        $users->password = $data["password"];
        $users->save();
        return $this->respondWithData($users);
    }
}

?>