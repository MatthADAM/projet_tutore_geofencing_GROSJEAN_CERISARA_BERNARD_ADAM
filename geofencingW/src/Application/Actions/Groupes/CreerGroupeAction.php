<?php

namespace App\Application\Actions\Groupes;

use App\Domain\User;
use Slim\App;
use Slim\Views\Twig;
use App\Domain\Groupe;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreerGroupeAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id = intval($args['id']);
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $data['nav'] = $url;
        if (isset($_SESSION['user']) || !is_null($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $view = Twig::fromRequest($request);
                $url['PostCreerGroup'] = "../creerGroup/{$id}";
                $data['urls'] = $url;
                $data['id_user'] = $id;

                return $view->render($response, 'CreerGroupe.html.twig', $data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nom = htmlentities($_POST['nomgr']);
                Groupe::create($nom,$id);
                header("Location: ../monCompte/$id");
                exit;
            } else {
                header('Location: /');
                exit;
            }
        } else {
            header('Location: ./inscription');
            exit;
        }
    }
}