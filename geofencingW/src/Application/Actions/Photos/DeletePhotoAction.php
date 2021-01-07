<?php


namespace App\Application\Actions\Photos;


use App\Domain\Commentaire;
use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use Cassandra\Date;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;
use function DI\create;

class DeletePhotoAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        if (isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $id = intval($args['id']);
            $data["id"] = $id;
            $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
            $url['getConversationsList'] = ['route' => '../galeries', 'name' => 'Galerie', 'method' => 'GET'];
            $user = User::where('email', '=', $_SESSION['user'])->first();
            $id_user = $user->id_user;
            $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
            $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
            $data['nav'] = $url;
            $user = User::where('email', "=", $_SESSION['user'])->first()->id_user;
            $id_galerie = Photos::where('id_photo', '=', "$id")->first()->id_galerie;
            $acces = User2Galerie::where(['id_user' => $user, 'id_galerie' => $id_galerie])->first();
            $acce = 0;
            if ($acces != null) {
                if ($acces->acces == 2 || $acces->acces==3) {
                    $acce = 2;
                }
            }
            if ($acce == 2) {
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $view = Twig::fromRequest($request);
                    // affiche le formulaire
                    return $view->render($response, 'DeletePhoto.html.twig', $data);
                } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    Commentaire::where('id_photo', '=', $id)->delete();
                    // Supp des associations
                    Photos::where('id_photo', '=', $id)->delete();
                }
                header("Location: ../galerieView/$id_galerie");
                exit;
            } else {
                header("Location: ../img/$id");
                exit;
            }
        }
        else{
                header('Location: ../connexion');
                exit;
        }
    }
}