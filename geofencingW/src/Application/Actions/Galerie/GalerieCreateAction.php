<?php


namespace App\Application\Actions\Galerie;


use App\Domain\Photos;
use App\Domain\User;
use App\Domain\Galerie;
use App\Domain\User2galerie;
use mysql_xdevapi\Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;

class GalerieCreateAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getGaleriesList'] = ['route' => './galeries', 'name' => 'Galeries', 'method' => 'GET'];
        
        if (isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $user = User::where('email', '=', $_SESSION['user'])->first();
            $id_user = $user->id_user;
            $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
            $url['deconnexionPost'] = ['route' => './deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
            $data['nav'] = $url;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user = User::where('email', "=", $_SESSION['user'])->first();
                $nom = htmlentities($_POST['nom']);
                $desc = htmlentities($_POST['description']);
                $type = htmlentities($_POST['type']);
                $mots = htmlentities($_POST['mots']);
                $titrephoto = htmlentities($_POST['titre']);
                $urlphoto = htmlentities($_POST['url']);
                $motsphoto = htmlentities($_POST['mots2']);
                header('Location: ./galeries');
                $galerie = Galerie::create($nom, $type, $desc, $mots);
                Photos::create($galerie->id_galerie, $titrephoto, $urlphoto, $motsphoto);
                User2Galerie::create($user->id_user, $galerie->id_galerie,3);
                // redirige sur la liste de conversation
                exit();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $view = Twig::fromRequest($request);
                // affiche le formulaire
                return $view->render($response, 'NewGalerie.html.twig', $data);
            }
        }else {
            header('Location: ./connexion');
            exit;
        }
    }
}