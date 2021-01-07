<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User;
use Slim\App;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ComptesConnexionAction
{

    public function __invoke(Request $request, Response $response): Response
    {
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $data['nav'] = $url;
        if(!isset($_SESSION['user']) || is_null($_SESSION['user'])) {
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                $view = Twig::fromRequest($request);
                $url['connexionPost'] = './connexion';
                $url['inscriptionGet'] = './inscription';
                $data['urls'] = $url;

                return $view->render($response, 'Connexion.html.twig', $data);
            } elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                    $password = $_POST['password'];

                    $compte = User::where('email', '=', $email)->first();
                    if (isset($compte) && $compte != null) {
                        if (password_verify($password, $compte->password)) {
                            $_SESSION['user'] = $email;
                            header('Location: ./');
                            exit;
                        }
                    }
                    header('Location: ./connexion');
                    exit;
                }
            }
            header('Location: ./connexion');
            exit;
        } else {
            header('Location: ./');
            exit;
        }
    }
}