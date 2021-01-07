<?php


namespace App\Application\Actions\Photos;


use App\Domain\Photos;
use App\Domain\User;
use App\Domain\Galerie;
use App\Domain\User2galerie;
use mysql_xdevapi\Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;

class UpdatePhotoAction
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
            $id_galerie = Photos::where('id_photo', '=', "$id")->first()->id_galerie;
            $acces = User2Galerie::where(['id_user' => $user, 'id_galerie' => $id_galerie])->first();
            $acce = 0;
            if ($acces != null) {
                if ($acces->acces == 2 || $acces->acces==3) {
                    $acce = 2;
                }
            }
            if ($acce == 2) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $photo = Photos::find($id);
                    $titre = htmlentities($_POST['titre']);
                    $url = htmlentities($_POST['imageUrl']);
                    $mots = htmlentities($_POST['mots']);

                    if ($_POST['titre'] != '') {
                        $photo->titre = $titre;
                    }
                    if ($_POST['imageUrl'] != '') {
                        $photo->imageUrl = $url;
                    }
                    if ($_POST['mots'] != '') {
                        $photo->motscles = $mots;
                    }
                    $photo->save();
                    header("Location: ../img/$id");
                    exit();
                } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $view = Twig::fromRequest($request);
                    // affiche le formulaire
                    return $view->render($response, 'UpdatePhoto.html.twig', $data);
                }
            } else {
                header("Location: ../img/$id");
                exit;
            }
        }else {
            header('Location: ../connexion');
            exit;
        }
    }
}