<?php


namespace App\Application\Actions\Groupes;

use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use App\Domain\User2group;
use App\Domain\Groupe;
use phpDocumentor\Reflection\Type;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;


class AfficherGroupeAction
{
	public function __invoke(Request $request, Response $response, $args): Response
	{
		$id = intval($args['id']);
        $view = Twig::fromRequest($request);
        $id_user = Groupe::where("id_group","=",$id)->first()->id_admin;
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getGalerieList'] = ['route' => '../galeries', 'name' => 'Galerie', 'method' => 'GET'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
                $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
                $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
                $data['nav'] = $url;
                $data['GetAjouterMembresGroupe'] = "../ajouterMembresGroupe/$id";

                $id_user = Groupe::where("id_group","=",$id)->first()->id_admin;

                $user = User::where("id_user", "=", $id_user)->first();
                if ($user->email == $_SESSION['user']) {

                    $user2group = User2group::where("id_group","=",$id)->get();

                    foreach($user2group as $u) {
                        $user = User::where("id_user","=", $u->id_user)->first();
                        $data['membres'][] = ['name' => $user->nom];
                        $data['postGroupeUserDelete'] = ['route' => "../deleteUserGroupe/$id/$user->id_user", 'name' => 'Supprimer utilisateur', 'method' => 'POST'];
                    }

                    // $data['nom_group'] = $group->nom_group;

                    return $view->render($response, 'Groupe.html.twig', $data);
                } else {
                    header('Location: /');
                    exit();
                }
            } else {
                header('Location: /');
                exit();
            }
		}
	}
}
