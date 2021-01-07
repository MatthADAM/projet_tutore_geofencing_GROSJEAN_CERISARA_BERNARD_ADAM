<?php


namespace App\Application\Actions\Galerie;


use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;

use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class GalerieRemoveUserAction
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
        $data['nav'] = $url;
        $galerie=Galerie::where('id_galerie','=',$id)->first();
        $acce=0;
        if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $user = User::where('email', "=", $_SESSION['user'])->first();
            $User2galerie=User2Galerie::where(['id_user'=> $user->id_user, 'id_galerie'=> $id])->first();
            if($User2galerie!=null){
                if($User2galerie->acces==3){
                    $acce=3;
                    $data['acces'] = 3;
                }else{
                    $data['acces'] = 0;
                }
            } else{
                $data['acces'] = 0;
            }
            if($galerie!=null) {
                if ($galerie->type <= 1 && $acce == 0) {
                    header("Location: ../galerieView/$id");
                    exit;
                }
            }
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(filter_var($_POST['conv-input-email'], FILTER_VALIDATE_EMAIL)){
                    $newUser = User::where('email', "=", $_POST['conv-input-email'])->first();
                    if (isset($newUser) && !is_null($newUser) && $_SESSION['user'] != $newUser->email) {
                        User2Galerie::where(['id_galerie'=> $id,'id_user'=>$newUser->id_user])->delete();
                        // redirige sur la liste de conversation
                        header("Location: ../galerieView/{$id}");
                        exit();
                    }
                }
                header("Location: ../removeUser/{$id}");
                exit();
            } elseif($acce==3) {
                if($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $view = Twig::fromRequest($request);
                    // affiche le formulaire
                    return $view->render($response, 'RemoveUser.html.twig', $data);
                }
            }else{
                header("Location: ../galerieView/{$id}");
                exit();
            }
        } else {
            header('Location: ../connexion');
            exit;
        }
    }
}