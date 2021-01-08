<?php


namespace App\Application\Actions\User;

use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use App\Domain\Groupe;
use phpDocumentor\Reflection\Type;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;


class MonCompteAction
{
	public function __invoke(Request $request, Response $response, $args): Response
	{
		$id = intval($args['id']);
        $view = Twig::fromRequest($request);
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
                $url['getMonCompte'] = ['route' => "../monCompte/$id", 'name' => 'mon compte', 'method' => 'GET'];
                $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
                $data['nav'] = $url;

                $user = User::where("id_user", "=", $id)->first();
                if ($user->email == $_SESSION['user']) {
                    $url['getUpdateUser'] = "../updateUser/{$id}";
                    $data['url'] = $url;

                    $data['accountUser'] = $_SESSION['user'];

                    $data['name'] = $user->nom;
                    $data['email'] = $user->email;
                    $data['infos'] = $user->infos;

                    return $view->render($response, 'MonCompte.html.twig', $data);
                    // echo json_encode($data);
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
