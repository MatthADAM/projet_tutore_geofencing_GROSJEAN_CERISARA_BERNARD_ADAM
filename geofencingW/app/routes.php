<?php
declare(strict_types=1);

use \App\Application\Actions\AccueilAction as AccueilAction;
use \App\Application\Actions\User\ComptesConnexionAction as ComptesConnexionAction;
use \App\Application\Actions\User\ComptesDeconnexionAction as ComptesDeconnexionAction;
use \App\Application\Actions\User\ComptesInscriptionAction as ComptesInscriptionAction;
use \App\Application\Actions\User\MonCompteAction as MonCompteAction;
use \App\Application\Actions\User\ModifierInfosUtilisateurAction as ModifierInfosUtilisateurAction;
use \App\Application\Actions\MapAction as MapAction;

// Import for users
use \App\Application\Actions\Api\Users\ListUsersAction;
use \App\Application\Actions\Api\Users\GetUsersAction;
use \App\Application\Actions\Api\Users\NewUsersAction;
use \App\Application\Actions\Api\Users\PutUsersAction;
use \App\Application\Actions\Api\Users\DeleteUsersAction;

// Import for points
use \App\Application\Actions\Api\Points\ListPointAction;
use \App\Application\Actions\Api\Points\GetPointAction;
use \App\Application\Actions\Api\Points\NewPointAction;
use \App\Application\Actions\Api\Points\PutPointAction;
use \App\Application\Actions\Api\Points\DeletePointAction;
use \App\Application\Actions\Api\Points\GetPointZoneAction;

// Import for zones
use \App\Application\Actions\Api\Zone\ListZoneAction;
use \App\Application\Actions\Api\Zone\GetZoneAction;
use \App\Application\Actions\Api\Zone\NewZoneAction;
use \App\Application\Actions\Api\Zone\PutZoneAction;
use \App\Application\Actions\Api\Zone\DeleteZoneAction;

// Import for informations
use \App\Application\Actions\Api\Infos\ListInfosAction;
use \App\Application\Actions\Api\Infos\GetInfosAction;
use \App\Application\Actions\Api\Infos\NewInfosAction;
use \App\Application\Actions\Api\Infos\PutInfosAction;
use \App\Application\Actions\Api\Infos\DeleteInfosAction;

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
    
    //afficher la carte
    $app->get('/map',MapAction::class)->setName("getMap");
    
    // Routes users
    $app->group('/api/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', GetUsersAction::class);
        $group->post('', NewUsersAction::class);
        $group->post('/{id}', PutUsersAction::class);
        $group->delete('/{id}', DeleteUsersAction::class);
    });
    
    // Routes points
    $app->group('/api/points', function (Group $group) {
        $group->get('', ListPointAction::class);
        $group->get('/{id}', GetPointAction::class);
        $group->get('/zone/{id}', GetPointZoneAction::class);
        $group->post('', NewPointAction::class);
        $group->post('/{id}', PutPointAction::class);
        $group->delete('/{id}', DeletePointAction::class);
    });

    // Routes zones
    $app->group('/api/zone', function (Group $group) {
        $group->get('', ListZoneAction::class);
        $group->get('/{id}', GetZoneAction::class);
        $group->post('', NewZoneAction::class);
        $group->post('/{id}', PutZoneAction::class);
        $group->delete('/{id}', DeleteZoneAction::class);
    });

    // Routes informations
    $app->group('/api/infos', function (Group $group) {
        $group->get('', ListInfosAction::class);
        $group->get('/{id}', GetInfosAction::class);
        $group->post('', NewInfosAction::class);
        $group->post('/{id}', PutInfosAction::class);
        $group->delete('/{id}', DeleteInfosAction::class);
    });
};
