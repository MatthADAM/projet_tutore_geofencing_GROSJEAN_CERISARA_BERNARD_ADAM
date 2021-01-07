<?php


namespace App\Application\Actions\Photos;

use App\Domain\Galerie;
use App\Domain\User;
use App\Domain\Photos;
use App\Domain\User2galerie;
use App\Domain\Commentaire;
use phpDocumentor\Reflection\Type;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Message;
use Slim\Views\Twig;


class AfficherPhotoAction
{
    
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id = intval($args['id']);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $view = Twig::fromRequest($request);
            
            $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
            $url['getGalerieList'] = ['route' => '../galeries', 'name' => 'Galerie', 'method' => 'GET'];
            if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
                $user = User::where('email', '=', $_SESSION['user'])->first();
                $id_user = $user->id_user;
                $url['getMonCompte'] = ['route' => "../monCompte/$id_user", 'name' => 'mon compte', 'method' => 'GET'];
                $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
            } else {
                $url['inscriptionGet'] = ['route' => '../inscription', 'name' => 'Inscription', 'method' => 'GET'];
                $url['connexionGet'] = ['route' => '../connexion', 'name' => 'Connexion', 'method' => 'GET'];
            }
            $data['nav'] = $url;
            $id_galerie = Photos::where('id_photo', '=', "$id")->first();
            $galerie=Galerie::where('id_galerie','=',$id_galerie->id_galerie)->first();
            $acce=0;
            if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
                $user = User::where('email', "=", $_SESSION['user'])->first()->id_user;
                $User2galerie=User2Galerie::where(['id_user'=> $user, 'id_galerie'=> $id_galerie->id_galerie])->first();
                if($User2galerie!=null){
                    if($User2galerie->acces==3){
                        $acce=3;
                        $data['acces'] = 3;
                    }elseif($User2galerie->acces==2){
                        $acce=2;
                        $data['acces'] = 2;
                    }elseif($User2galerie->acces==1){
                        $acce=1;
                        $data['acces'] = 1;
                    }
                    else{
                        $data['acces'] = 0;
                    }
                }
            }
            if($galerie!=null) {
                if ($galerie->type == 1 && $acce == 0) {
                    header("Location: ../galeries");
                    exit;
                }
            }
            $url['getPhotoDelete'] = "../photoDelete/{$id}";
            $url['getPhotoUpdate'] = "../photoUpdate/{$id}";
            $url['postMessage'] = "../sendMessage/$id}";
            
            $photo = Photos::where("id_photo","=",$id)->get();
            $photoNext = Photos::where("id_galerie","=",$photo[0]->id_galerie)->where("id_photo",">",$id)->first();
            $photoPrev = Photos::where("id_galerie","=",$photo[0]->id_galerie)->where("id_photo","<",$id)->get()->last();
            $commentaires = Commentaire::where("id_photo","=",$id)->get();
            
            if($photoPrev != null) {
                $idprev = $photoPrev->id_photo;
            } else {
                $idprev = $id;
            }
            if($photoNext != null) {
                $idnext = $photoNext->id_photo;
            } else {
                $idnext = $id;
            }
            
            $url['getImagePrev'] = "../img/$idprev";
            $url['getImageNext'] = "../img/$idnext";
            
            $data['urls'] = $url;
            
            $data['photo'][] = ['titre' => $photo[0]->titre, 'imageUrl' => $photo[0]->imageUrl, 'idPhoto' => $photo[0]->id_photo, 'idGalerie' => $photo[0]->id_galerie, 'motscles' => $photo[0]->motsCles, 'date' => $photo[0]->date];
            foreach ($commentaires as $comm) {
                $userCom = User::select("nom")->where("id_user","=",$comm->id_user)->first();
                $data['commentaires'][] = ['id_commentaire' => $comm->id_commentaire, 'id_photo' => $comm->id_photo,'user' => $userCom->nom,'content' => $comm->content,'date' => $comm->date];
                $data['postMessageDelete'] = ['route' => "../deleteMessage/$comm->id_commentaire", 'name' => 'Supprimer', 'method' => 'POST'];
            }
            return $view->render($response, 'Photo.html.twig', $data);
            
        }else {
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            header("Location: $actual_link");
            exit;
        }
    }
}