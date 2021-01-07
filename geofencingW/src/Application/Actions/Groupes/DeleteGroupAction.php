<?php


namespace App\Application\Actions\Groupes;


use App\Domain\Commentaire;
use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use App\Domain\User2group;
use App\Domain\Groupe;
use Cassandra\Date;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;
use function DI\create;

class DeleteGroupAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        if (isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $id = intval($args['id']);
            $id_user = User::where("email","=",$_SESSION['user'])->first()->id_user;
            $data["id"] = $id_user;
            $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
            $url['getConversationsList'] = ['route' => '../galeries', 'name' => 'Galerie', 'method' => 'GET'];
            $user = User::where('email', '=', $_SESSION['user'])->first();
            $id_user = $user->id_user;
            $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
            $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
            $data['nav'] = $url;
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $group = Groupe::where("id_group","=",$id)->first();
                if($group->id_admin == $id_user) {
                    $view = Twig::fromRequest($request);

                    $data['group'][] = ['name' => $group->nom_group];

                    // affiche le formulaire
                    return $view->render($response, 'DeleteGroup.html.twig', $data);
                } else {
                    header("Location: /");
                    exit;
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                User2group::where("id_group","=",$id)->delete();
                Groupe::where("id_group","=",$id)->delete();
            }
            header("Location: ../monCompte/$id_user");
            exit;
        }
        else{
                header('Location: ../connexion');
                exit;
        }
    }
}