<?php

namespace App\Application\Actions\User;

use App\Domain\User;
use Slim\App;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ModifierInfosUtilisateurAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id = intval($args['id']);
        $view = Twig::fromRequest($request);
        $url['getAccueil'] = ['route' => '/', 'name' => 'Accueil', 'method' => 'GET'];
        $url['getGalerieList'] = ['route' => '../galeries', 'name' => 'Galerie', 'method' => 'GET'];
        if(isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
            $url['getMonCompte'] = ['route' => "../monCompte/$id", 'name' => 'mon compte', 'method' => 'GET'];
            $url['deconnexionPost'] = ['route' => '../deconnexion', 'name' => 'Deconnexion', 'method' => 'POST'];
            $data['nav'] = $url;
        
            $user = User::where("id_user", "=", $id)->first();
            if ($user->email == $_SESSION['user']) {
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $view = Twig::fromRequest($request);
                    $url['connexionGet'] = './connexion';
                    $url['inscriptionPost'] = './inscription';
                    $data['urls'] = $url;

                    $data['name'] = $user->nom;
                    $data['email'] = $user->email;
                    $data['infos'] = $user->infos;

                    return $view->render($response, 'ModifierInfosUtilisateur.html.twig', $data);
                } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $user = User::find($id);
                    $nom = htmlentities($_POST['nom']);
                    $email = htmlentities($_POST['email']);
                    $infos = htmlentities($_POST['infos']);
                    $password = htmlentities($_POST['password']);
                    $confpassword = htmlentities($_POST['confpassword']);

                
                    if($_POST['nom']!=''){
                        $user->nom = $nom;
                    }
                    if($_POST['email']!=''){
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $user->email = $email;
                            $_SESSION['user'] = $email;
                        }
                    }
                    if($_POST['infos']!=''){
                        $user->infos = $infos;
                    }
                    if($_POST['password']!=''){
                        if ($confpassword == $password) {
                            $user->password = password_hash($password, PASSWORD_DEFAULT);
                        }
                    }
                    $user->save();
                    header("Location: ../monCompte/$id");
                    exit();
                    }
                } else {
                    header("Location: ./monCompte/$id");
                    exit;
                }
        } else {
            header('Location: /');
            exit;
        }
    }
}