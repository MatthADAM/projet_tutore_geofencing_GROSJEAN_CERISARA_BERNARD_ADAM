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

class DeleteCommentaireAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {

        $id = intval($args['id']);
        $comment=Commentaire::where("id_commentaire","=",$id)->first();
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
                $acce=0;
                $photo = Photos::where('id_photo', '=', $comment->id_photo)->first();
                $user = User::where('email', '=', $_SESSION['user'])->first();
                $User2galerie=User2Galerie::where(['id_user'=> $user->id_user, 'id_galerie'=> $photo->id_galerie])->first();
                if($User2galerie!=null){
                    if($User2galerie->acces==3){
                        $acce=3;
                        $data['acces'] = 3;
                    }
                    if($acce==3){
                        Commentaire::where("id_commentaire","=",$id)->delete();
                    }
                }
                header("Location: ../img/$comment->id_photo");
                exit;
            }
            header("Location: ../img/$comment->id_photo");
            exit;
        } else {
            header('Location: ../connexion');
            exit;
        }
    }
}