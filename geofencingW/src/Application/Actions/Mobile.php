<?php

namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use App\Domain\User;

class Mobile
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $view = Twig::fromRequest($request);
            $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
            if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
                $user = User::where('email', '=', $_SESSION['user'])->first();
                $id_user = $user->id_user;
                $url['getMap'] = ['route' => '../map', 'name' => 'Map', 'method' => 'GET'];
                if ($user->admin==1) {
                    $url['inscriptionGet'] = ['route' => '../inscription', 'name' => 'Inscription', 'method' => 'GET'];
                }
				$url['getMonCompte'] = ['route' => "../../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
				$url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
                $data['connecte'] = 'true';
            }
            $id = intval($args['id']);
            $data['idM'] =  ['idMo' => $id];
            $data['nav'] = $url;
            $data['urls'] = $url;
            return $view->render($response, 'Mobile.html.twig', $data);
        }
    }
}