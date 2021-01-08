<?php

namespace App\Application\Actions\User;

use App\Domain\User;
use Slim\App;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ComptesInscriptionAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $data['nav'] = $url;
        if (!isset($_SESSION['user']) || is_null($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $view = Twig::fromRequest($request);
                $url['connexionGet'] = './connexion';
                $url['inscriptionPost'] = './inscription';
                $data['urls'] = $url;

                return $view->render($response, 'Inscription.html.twig', $data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $email = htmlentities($_POST['email']);
                $password = htmlentities($_POST['password']);
                $confpassword = htmlentities($_POST['confpassword']);

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $compteEmail = User::where('email', '=', $email)->first();
                    if (is_null($compteEmail)) {
                        if ($confpassword == $password) {
                            User::create($email, password_hash($password, PASSWORD_DEFAULT));
                            header('Location: ./connexion');
                            exit;
                        } else {
                            header('Location: ./inscription');
                            exit;
                        }
                    } else {
                        header('Location: ./inscription');
                        exit;
                    }
                }
            } else {
                header('Location: ./inscription');
                exit;
            }
        } else {
            header('Location: ./');
            exit;
        }
    }
}