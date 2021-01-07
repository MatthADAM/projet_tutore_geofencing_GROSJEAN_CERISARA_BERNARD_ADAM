<?php


namespace App\Application\Actions\Groupes;


use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use App\Domain\User2group;

use Illuminate\Database\Capsule\Manager as DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class AjouterMembresGroupeAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id = intval($args['id']);

        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getGalerieList'] = ['route' => '../galeries', 'name' => 'Galerie', 'method' => 'GET'];
        if (isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $user = User::where('email', '=', $_SESSION['user'])->first();
            $id_user = $user->id_user;
            $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
            $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
        } else {
            $url['inscriptionGet'] = ['route' => '../inscription', 'name' => 'Inscription', 'method' => 'GET'];
            $url['connexionGet'] = ['route' => '../connexion', 'name' => 'Connexion', 'method' => 'GET'];
        }
        $data['nav'] = $url;
        if (isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $view = Twig::fromRequest($request);
                $url['PostAjouterMembresGroupe'] = "../ajouterMembresGroupe/{$id}";
                $data['urls'] = $url;

                return $view->render($response, 'AjouterMembresGroupe.html.twig', $data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                    if ($_SESSION['user'] != $_POST['mail']) {
                        $mail = $_POST['mail'];
                        $exist=User::where("email","=",$mail)->first();
                        if($exist!=null){
                        $newuser = User::where("email", "=", $mail)->first();
                        User2group::create($id, $newuser->id_user);
                        header("Location: ../group/$id");
                        exit;
                        }
                    }
                }
                header("Location: ../ajouterMembresGroupe/$id");
                exit;
            }
        } else {
            header('Location: ../connexion');
            exit;
        }
    }
}
