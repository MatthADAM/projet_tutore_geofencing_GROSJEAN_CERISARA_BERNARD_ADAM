<?php


namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use App\Domain\Galerie;
use App\Domain\Photos;
use App\Domain\User;

class AccueilAction
{

    public function __invoke(Request $request, Response $response): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $view = Twig::fromRequest($request);
            $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
            if(!isset($_SESSION['user']) || is_null($_SESSION['user'])) {

                $url['inscriptionGet'] = ['route' => './inscription', 'name' => 'Inscription', 'method' => 'GET'];
                $url['connexionGet'] = ['route' => './connexion', 'name' => 'Connexion', 'method' => 'GET'];
                $data['connecte'] = 'false';

            } else {
                $user = User::where('email', '=', $_SESSION['user'])->first();
                $id_user = $user->id_user;
				$url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
				$url['deconnexionPost'] = ['route' => './deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
                $data['connecte'] = 'true';
            }
            $data['nav'] = $url;
            // $url['getGalerie'] = './galerieView'; ---- EXEMPLE

            $data['urls'] = $url;
            return $view->render($response, 'Accueil.html.twig', $data);
        }
    }
}