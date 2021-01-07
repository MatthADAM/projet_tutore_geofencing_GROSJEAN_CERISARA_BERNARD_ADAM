<?php


namespace App\Application\Actions\Photos;


use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use App\Domain\Commentaire;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;

class CommentaireAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {

        $id = intval($args['id']);
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getGalerieList'] = ['route' => '../galeries', 'name' => 'Galerie', 'method' => 'GET'];
        if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $user = User::where('email', '=', $_SESSION['user'])->first();
            $id_user = $user->id_user;
            $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
            $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
        } else {
            $url['inscriptionGet'] = ['route' => '../inscription', 'name' => 'Inscription', 'method' => 'GET'];
            $url['connexionGet'] = ['route' => '../connexion', 'name' => 'Connexion', 'method' => 'GET'];
        }
        if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user = User::where('email', '=', $_SESSION['user'])->first();
                $content = filter_var($_POST['message-input-content'], FILTER_SANITIZE_STRING);
                $today = date("Y-m-d H:i:s");
                Commentaire::create($id, $user->id_user, $content, $today);
                header("Location: ../img/$id");
                exit;
            }
            header("Location: ../img/$id");
            exit;
        } else {
            header('Location: ../connexion');
            exit;
        }
    }
}