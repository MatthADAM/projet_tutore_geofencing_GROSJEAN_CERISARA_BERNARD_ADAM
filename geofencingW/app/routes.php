<?php
declare(strict_types=1);

use \App\Application\Actions\AccueilAction as AccueilAction;
use \App\Application\Actions\User\ComptesConnexionAction as ComptesConnexionAction;
use \App\Application\Actions\User\ComptesDeconnexionAction as ComptesDeconnexionAction;
use \App\Application\Actions\User\ComptesInscriptionAction as ComptesInscriptionAction;
use \App\Application\Actions\User\MonCompteAction as MonCompteAction;
use \App\Application\Actions\User\ModifierInfosUtilisateurAction as ModifierInfosUtilisateurAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->get('/', AccueilAction::class)->setName("getAccueil");;

    /* Connexion */

    $app->get('/connexion', ComptesConnexionAction::class)->setName("getConnexion");

    $app->post('/connexion', ComptesConnexionAction::class)->setName("postConnexion");

    $app->post('/deconnexion', ComptesDeconnexionAction::class)->setName("postDeconnexion");

    /* Inscription */

    $app->get('/inscription', ComptesInscriptionAction::class)->setName("getInscription");

    $app->post('/inscription', ComptesInscriptionAction::class)->setName("postInscription");

    //update User
    $app->get('/updateUser/{id}',ModifierInfosUtilisateurAction::class)->setName("getUpdateUser");
    $app->post('/updateUser/{id}',ModifierInfosUtilisateurAction::class)->setName("postUpdateUser");
    
    //voir son compte
    $app->get('/monCompte/{id}',MonCompteAction::class)->setName("getMonCompte");
    $app->post('/monCompte/{id}',MonCompteAction::class)->setName("postMonCompte");
};
