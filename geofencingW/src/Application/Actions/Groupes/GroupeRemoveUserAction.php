<?php


namespace App\Application\Actions\Groupes;


use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use App\Domain\User2group;
use App\Domain\Groupe;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class GroupeRemoveUserAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id_u = intval($args['id_u']);
        $id_g = intval($args['id_g']);
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getGalerieList'] = ['route' => '../../galeries', 'name' => 'Galerie', 'method' => 'GET'];
        if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $user = User::where('email', '=', $_SESSION['user'])->first();
            $id_user = $user->id_user;
            $url['getMonCompte'] = ['route' => "../../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
            $url['deconnexionPost'] = ['route' => '../../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
        } else {
            $url['inscriptionGet'] = ['route' => '../../inscription', 'name' => 'Inscription', 'method' => 'GET'];
            $url['connexionGet'] = ['route' => '../../connexion', 'name' => 'Connexion', 'method' => 'GET'];
        }
        $data['nav'] = $url;
        if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                User2group::where(["id_group"=>$id_g,"id_user"=>$id_u])->delete();
                header("Location: ../../group/$id_g");
                exit();
            }else {
                header("Location: ../../group/$id_g");
                exit();
            }
        } else {
            header('Location: ../../connexion');
            exit;
        }
    }
}