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


class GalerieAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id = intval($args['id']);
        error_reporting(0);
        $i = 0;
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

            
                if($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $url['getAjoutImage'] = "../addimg/{$id}";
                    $url['getImage'] = "../img";
                    $url['getGalerieUpdate'] = "../galerieUpdate/{$id}";
                    $url['getGalerieDelete'] = "../galerieDelete/{$id}";
                    $url['getGalerieAddUser'] = "../addUser/{$id}";
                    $url['getGalerieAddGroup'] = "../addGroup/{$id}";
                    $url['getGalerieRemoveUser'] = "../removeUser/{$id}";
                    $url['getGalerieRemoveGroup'] = "../deleteGroup/{$id}";
                    $url['getGalerieLeaveUser'] = "../leaveGalerie/{$id}";

                    $data['urls'] = $url;
                    $galerie=Galerie::where('id_galerie','=',$id)->first();
                    $acce=0;
                    if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
                        $user = User::where('email', "=", $_SESSION['user'])->first()->id_user;
                        $User2galerie=User2Galerie::where(['id_user'=> $user, 'id_galerie'=> $id])->first();
                        if($User2galerie!=null){
                            if($User2galerie->acces==2){
                                $acce=2;
                                $data['acces'] = 2;
                            }elseif($User2galerie->acces==1){
                                $acce=1;
                                $data['acces'] = 1;
                            }elseif($User2galerie->acces==3){
                                $acce=3;
                                $data['acces'] = 3;
                            }else{
                                $data['acces'] = 0;
                            }
                        } else{
                        $data['acces'] = 0;
                        
                    }
                   // $acces=User2Galerie::where('id_user','=',$user)->where('id_galerie','=',$id)->first()->acces;
                }
                    if($galerie!=null) {
                        if ($galerie->type == 1 && $acce == 0) {
                            header('Location: ../galeries');
                            exit;
                        }
                    }
                    $nomGalerie = Galerie::select("nom")->where("id_galerie","=",$id)->first();
                    $data['name'] = ['nom'=>$nomGalerie->nom];

                    $user2gal = User2Galerie::select("id_user")->where("id_galerie","=",$id)->first();
                    $crea = User::select("nom")->where("id_user","=",$user2gal->id_user)->first();
                    $data['createur'] = $crea->nom;

                    $datecrea = Galerie::select("date")->where("id_galerie","=",$id)->first();
                    $data['dateCrea'] = $datecrea->date;
                    
                    $motscles = Galerie::select("motscles")->where("id_galerie","=",$id)->first();
                    $data['motscles'] = $motscles->motscles;


                    $photos = Photos::where("id_galerie","=",$id)->get();

                    foreach ($photos as $picture) {
                        $i++;
                        $data['liste'][] = ['name' => "Photo n°" . $i . " : " . $picture->titre,'imageUrl' => $picture->imageUrl, 'imgId' => $picture->id_photo];
                    }

                    $data['nbphotos'] = $i;

                    // $user2gal = User2Galerie::select("id_user")->where("id_galerie","=",$id)->first();
                    // $c = User::select("email")->where("id_user","=",$user2gal->id_user)->first();
                    // $data['cre'] = $c->email;
                    // $data['email'] = $_SESSION['user'];
                    return $view->render($response, 'Galerie.html.twig', $data);
                } else {
                    header('Location: ../galeries');
                    exit;
                }
            
        }
    }
}
