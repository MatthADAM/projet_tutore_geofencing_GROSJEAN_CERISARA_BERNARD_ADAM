<?php


namespace App\Application\Actions\Galerie;


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

class GalerieAddGroupeAction
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
                $data["test"]=$galerie;
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

                $groupe = Groupe::where("nom_group","=",$_POST['menu_groupes'])->first();
                $user2group = User2group::where("id_group","=",$groupe->id_group)->get();
                $droit = $_POST['type'];

                foreach ($user2group as $u) {
                    $newUser = User::where('id_user', "=", $u->id_user)->first();
                    if (isset($newUser) && !is_null($newUser) && $_SESSION['user'] != $newUser->email) {
                        User2galerie::create($newUser->id_user,$id,$droit);
                    }
                }
                // redirige sur la liste des galeries
                header("Location: ../galerieView/{$id}");
                exit();
            } elseif($acce==3) {
                if($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $view = Twig::fromRequest($request);

                    $id_user = User::where("email","=",$_SESSION['user'])->first()->id_user;
                    $groupes = Groupe::where("id_admin","=",$id_user)->get();
                    foreach ($groupes as $g) {
                        $data['groupe'][] = ['name' => $g->nom_group, 'id_group' => $g->id_group];
                    }

                    // affiche le formulaire
                    return $view->render($response, 'AddGroupe2Gallerie.html.twig', $data);
                }
            }else{
                header("Location: ../galerieView/$id");
                exit;
            }
        } else {
            header('Location: ../connexion');
            exit;
        }
    }
}