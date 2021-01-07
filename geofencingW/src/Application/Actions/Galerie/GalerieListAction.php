<?php


namespace App\Application\Actions\Galerie;


use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use phpDocumentor\Reflection\Type;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;

class GalerieListAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getGalerie'] = './galerieView';
        if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $data['connecte'] = 'true';
            if($_SERVER['REQUEST_METHOD'] === 'GET') {
                $url['getGaleriesList'] = ['route' => './galeries', 'name' => 'Galerie', 'method' => 'GET'];
                $user = User::where('email', '=', $_SESSION['user'])->first();
                $id_user = $user->id_user;
				$url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
				$url['deconnexionPost'] = ['route' => './deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];

                $url['getGalerieForm'] = './newGalerie';
                $url['postGalerieForm'] = './newGalerie';

                $compte = User::where('email', "=", $_SESSION['user'])->first();
                $galeriesProprio=User2galerie::where(['id_user'=>$compte->id_user,'acces'=>3])->get();
                foreach ($galeriesProprio as $galPro){
                    $galeriesPro=Galerie::where('id_galerie','=',$galPro->id_galerie)->first();
                    $photo = Photos::select('imageUrl')->where('id_galerie','=',$galPro->id_galerie)->first();
                    $data['galeriesProprio'][] = ['name' => $galeriesPro->nom,'imageUrl'=>$photo,'id' => $galeriesPro->id_galerie];
                }
                $galeriesPrivate = User2galerie::where('id_user','=',$compte->id_user)->whereIn('acces',[1,2])->get();
                foreach ($galeriesPrivate as $galPr){
                    $galeriesPri=Galerie::where('id_galerie','=',$galPr->id_galerie)->first();
                    $photo = Photos::select('imageUrl')->where('id_galerie','=',$galPr->id_galerie)->first();
                    $data['galeriesPr'][] = ['name' => $galeriesPri->nom,'imageUrl'=>$photo,'id' => $galeriesPri->id_galerie];
                }
            } else {
                header('Location: ./');
                exit;
            }
        }else{
                $data['connecte'] = 'false';
                $url['getGalerieList'] = ['route' => './galeries', 'name' => 'Galerie', 'method' => 'GET'];
                $url['inscriptionGet'] = ['route' => './inscription', 'name' => 'Inscription', 'method' => 'GET'];
                $url['connexionGet'] = ['route' => './connexion', 'name' => 'Connexion', 'method' => 'GET'];
        }

        $view = Twig::fromRequest($request);
        $data['nav'] = $url;
        $data['urls'] = $url;
        $galeriesPublic = Galerie::Where("type","=",0)->get();
        foreach ($galeriesPublic as $galPu){
            $photo = Photos::select('imageUrl')->where('id_galerie','=',$galPu->id_galerie)->first();
            $data['galeriesPu'][] = ['name' => $galPu->nom,'imageUrl'=>$photo,'id' => $galPu->id_galerie];
        }
        return $view->render($response, 'GalerieList.html.twig', $data);
    }
}