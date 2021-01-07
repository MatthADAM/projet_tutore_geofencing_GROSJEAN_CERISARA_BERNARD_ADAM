<?php

namespace App\Application\Actions\Photos;

use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use Slim\App;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AjoutPhotoAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getGaleriesList'] = ['route' => '../galeries', 'name' => 'Galeries', 'method' => 'GET'];
        if (isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $user = User::where('email', '=', $_SESSION['user'])->first();
            $id_user = $user->id_user;
            $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
            $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
            $data['nav'] = $url;
            $id = $args['id'];
        
            $user = User::where('email', "=", $_SESSION['user'])->first()->id_user;
            $acces=User2Galerie::where(['id_user'=> $user, 'id_galerie'=> $id])->first();
            $acce=0;
            if($acces!=null){
                if($acces->acces==2 || $acces->acces==3){
                    $acce=2;
                }
            }
            if($acce==2){
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $view = Twig::fromRequest($request);
                    $url['postAjoutImage'] = "../addimg/$id";
                    $data['urls'] = $url;

                    return $view->render($response, 'AjoutPhotos.html.twig', $data);
                } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    $titre = htmlentities($_POST['titre']);
                    $imgurl = htmlentities($_POST['url']);
                    $motscles = htmlentities($_POST['motscles']);
                    $id_galerie = intval($args['id']);

                    Photos::create($id_galerie, $titre, $imgurl, $motscles);
                    header("Location: ../galerieView/$id");
                    exit;
                } else {
                    header('Location: ../galeries');
                    exit;
                }
            } else {
                header("Location: ../galerieView/$id");
                exit;
            }
        }else{
            header('Location: ../connexion');
            exit;
        }
    }
}