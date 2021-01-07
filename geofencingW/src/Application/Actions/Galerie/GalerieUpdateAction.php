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

class GalerieUpdateAction
{
    public function __invoke(Request $request, Response $response,$args): Response
    {
        $id = intval($args['id']);
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getGaleriesList'] = ['route' => '../galeries', 'name' => 'Galeries', 'method' => 'GET'];
        
        if (isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $user = User::where('email', '=', $_SESSION['user'])->first();
            $id_user = $user->id_user;
            $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
            $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
            $data['nav'] = $url;

            $user = User::where('email', "=", $_SESSION['user'])->first()->id_user;
            $acces=User2Galerie::where(['id_user'=> $user, 'id_galerie'=> $id])->first();
            $acce=0;
            if($acces!=null){
                if($acces->acces==3){
                    $acce=3;
                }
            }
            if($acce==3){
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $galerie = Galerie::find($id);
                    $nom = htmlentities($_POST['nom']);
                    $desc = htmlentities($_POST['description']);
                    $type = htmlentities($_POST['type']);
                    $mots = htmlentities($_POST['mots']);

                    if($_POST['nom']!=''){
                        $galerie->nom = $nom;
                    }
                    if($_POST['description']!=''){
                        $galerie->description = $desc;
                    }
                    if($_POST['type']!=$galerie->type){
                        $galerie->type = $type;
                    }
                    if($_POST['mots']!=''){
                        $galerie->motscles = $mots;
                    }
                    $galerie->save();
                    header("Location: ../galerieView/$id");
                    exit();
                } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $view = Twig::fromRequest($request);
                    // affiche le formulaire
                    return $view->render($response, 'UpdateGalerie.html.twig', $data);
                }
            }else {
                header("Location: ../galerieView/$id");
                exit;
            }
        }
        else {
            header('Location: ../connexion');
            exit;
        }
    }
}