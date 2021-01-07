<?php


namespace App\Application\Actions\Galerie;


use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use Cassandra\Date;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;
use function DI\create;

class GalerieDeleteAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id = intval($args['id']);
        $data["id"] = $id;
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getConversationsList'] = ['route' => '../galeries', 'name' => 'Galerie', 'method' => 'GET'];
        $user = User::where('email', '=', $_SESSION['user'])->first();
        $id_user = $user->id_user;
        $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
        $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
        $data['nav'] = $url;
        $galerie=Galerie::where('id_galerie','=',$id)->first();
        $acce=0;
        if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {

            $user = User::where('email', "=", $_SESSION['user'])->first()->id_user;
            $acces=User2Galerie::where(['id_user'=> $user, 'id_galerie'=> $id])->first();
            $acce=0;
            if($acces!=null){
                if($acces->acces==3){
                    $acce=3;
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
            if($acce==3){
                if($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $view = Twig::fromRequest($request);
                    // affiche le formulaire
                    return $view->render($response, 'DeleteGalerie.html.twig', $data);
                }
                elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Supp des associations
                    Photos::where('id_galerie', '=', $id)->delete();
                    User2Galerie::where('id_galerie', '=', $id)->delete();
                    //supp de l'entité
                    Galerie::where('id_galerie', '=', $id)->delete();
                }
                header('Location: ../galeries');
                exit;
            }else {
                header("Location: ../galerieView/$id");
                exit;
            }
        }
        else
            header('Location: ../connexion');
        exit;
    }
}