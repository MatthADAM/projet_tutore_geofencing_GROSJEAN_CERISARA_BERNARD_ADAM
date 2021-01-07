<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Slim\App;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ComptesDeconnexionAction
{

    public function __invoke(Request $request, Response $response): Response
    {
        if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        unset($_SESSION['user']);
                        header('Location: ./');
                        exit;
            } else {
                header('Location: ./');
                exit;
            }
        }
    }
}