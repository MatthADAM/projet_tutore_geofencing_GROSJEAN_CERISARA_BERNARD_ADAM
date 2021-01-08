<?php


namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use App\Domain\Galerie;
use App\Domain\Photos;
use App\Domain\User;

class AccueilAction
{

    public function __invoke(Request $request, Response $response): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $view = Twig::fromRequest($request);
            $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
            if(!isset($_SESSION['user']) || is_null($_SESSION['user'])) {

                // $url['getGalerieList'] = ['route' => './galeries', 'name' => 'Galerie', 'method' => 'GET'];
                $url['inscriptionGet'] = ['route' => './inscription', 'name' => 'Inscription', 'method' => 'GET'];
                $url['connexionGet'] = ['route' => './connexion', 'name' => 'Connexion', 'method' => 'GET'];
                $data['connecte'] = 'false';

            } else {
                // $url['getGalerieList'] = ['route' => './galeries', 'name' => 'Galerie', 'method' => 'GET'];
                $user = User::where('email', '=', $_SESSION['user'])->first();
                $id_user = $user->id_user;
				$url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
				$url['deconnexionPost'] = ['route' => './deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
                $data['connecte'] = 'true';
            }
            $data['nav'] = $url;
            $url['getGalerie'] = './galerieView';

            $data['urls'] = $url;
            $galeriesPublic = Galerie::Where("type","=",0)->get();
            $nbgalpu = count($galeriesPublic);
            if($nbgalpu<=3){
                foreach ($galeriesPublic as $galPu){
                    $photo = Photos::select('imageUrl')->where('id_galerie','=',$galPu->id_galerie)->first();
                    $data['galeriesPu'][] = ['name' => $galPu->nom,'imageUrl'=>$photo,'id' => $galPu->id_galerie];
                }
            }else{
                $a = rand(0,$nbgalpu-1);
                $b = rand(0,$nbgalpu-1);
                $c = rand(0,$nbgalpu-1);
                while($b === $a){
                    $b = rand(0,$nbgalpu-1);
                }
                while($c === $a || $c === $b){
                    $c = rand(0,$nbgalpu-1);
                }
                $photo = Photos::select('imageUrl')->where('id_galerie','=',$galeriesPublic[$a]->id_galerie)->first();
                $data['galeriesPu'][] = ['name' => $galeriesPublic[$a]->nom,'imageUrl'=>$photo,'id' => $galeriesPublic[$a]->id_galerie];

                $photo = Photos::select('imageUrl')->where('id_galerie','=',$galeriesPublic[$b]->id_galerie)->first();
                $data['galeriesPu'][] = ['name' => $galeriesPublic[$b]->nom,'imageUrl'=>$photo,'id' => $galeriesPublic[$b]->id_galerie];

                $photo = Photos::select('imageUrl')->where('id_galerie','=',$galeriesPublic[$c]->id_galerie)->first();
                $data['galeriesPu'][] = ['name' => $galeriesPublic[$c]->nom,'imageUrl'=>$photo,'id' => $galeriesPublic[$c]->id_galerie];
            }
            return $view->render($response, 'Accueil.html.twig', $data);
        }
    }
}