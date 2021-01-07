<?php
declare(strict_types=1);

use \App\Application\Actions\AccueilAction as AccueilAction;
use \App\Application\Actions\User\ComptesConnexionAction as ComptesConnexionAction;
use \App\Application\Actions\User\ComptesDeconnexionAction as ComptesDeconnexionAction;
use \App\Application\Actions\User\ComptesInscriptionAction as ComptesInscriptionAction;
use \App\Application\Actions\User\MonCompteAction as MonCompteAction;
use \App\Application\Actions\User\ModifierInfosUtilisateurAction as ModifierInfosUtilisateurAction;
use \App\Application\Actions\Galerie\GalerieListAction as GalerieListAction;
use \App\Application\Actions\Photos\AjoutPhotoAction as AjoutPhotoAction;
use \App\Application\Actions\Photos\CommentaireAction as CommentaireAction;
use \App\Application\Actions\Photos\DeleteCommentaireAction as DeleteCommentaireAction;
use \App\Application\Actions\Photos\AfficherPhotoAction as AfficherPhotoAction;
use \App\Application\Actions\Photos\DeletePhotoAction as DeletePhotoAction;
use \App\Application\Actions\Photos\UpdatePhotoAction as UpdatePhotoAction;
use \App\Application\Actions\Galerie\GalerieCreateAction as GalerieCreateAction;
use \App\Application\Actions\Galerie\GalerieUpdateAction as GalerieUpdateAction;
use \App\Application\Actions\Galerie\GalerieDeleteAction as GalerieDeleteAction;
use \App\Application\Actions\Galerie\GalerieAddUserAction as GalerieAddUserAction;
use \App\Application\Actions\Galerie\GalerieRemoveUserAction as GalerieRemoveUserAction;
use \App\Application\Actions\Galerie\GalerieLeaveGalerieAction as GalerieLeaveGalerieAction;
use \App\Application\Actions\Groupes\AfficherGroupeAction as AfficherGroupeAction;
use \App\Application\Actions\Groupes\CreerGroupeAction as CreerGroupeAction;
use \App\Application\Actions\Groupes\AjouterMembresGroupeAction as AjouterMembresGroupeAction;
use \App\Application\Actions\Groupes\DeleteGroupAction as DeleteGroupAction;
use \App\Application\Actions\Groupes\GroupeRemoveUserAction as GroupeRemoveUserAction;
use \App\Application\Actions\Galerie\GalerieAction as GalerieAction;
use \App\Application\Actions\Galerie\GalerieAddGroupeAction as GalerieAddGroupeAction;
use \App\Application\Actions\Galerie\GalerieRemoveGroupeAction as GalerieRemoveGroupeAction;
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

    //get the list of galerie
    $app->get('/galeries', GalerieListAction::class)->setName("getGaleriesList");
    // new Galerie form
    $app->get('/newGalerie', GalerieCreateAction::class)->setName("getGalerieForm");

    //create a new Galerie
    $app->post('/newGalerie', GalerieCreateAction::class)->setName("postGalerieForm");

    // ajout d'images
    $app->get('/addimg/{id}', AjoutPhotoAction::class)->setName("getAjoutImage");
    $app->post('/addimg/{id}', AjoutPhotoAction::class)->setName("postAjoutImage");

    // display galerie
    $app->get('/galerieView/{id}',GalerieAction::class)->setName("getGalerieContent");

    //modify galerie
    $app->get('/galerieUpdate/{id}',GalerieUpdateAction::class)->setName("getGalerieUpdate");
    $app->post('/galerieUpdate/{id}',GalerieUpdateAction::class)->setName("postGalerieUpdate");

    //delete galerie
    $app->get('/galerieDelete/{id}',GalerieDeleteAction::class)->setName("getGalerieDelete");
    $app->post('/galerieDelete/{id}',GalerieDeleteAction::class)->setName("postGalerieDelete");

    //add user
    $app->get('/addUser/{id}',GalerieAddUserAction::class)->setName("getGalerieAddUser");
    $app->post('/addUser/{id}',GalerieAddUserAction::class)->setName("postGalerieAddUser");

    //update User
    $app->get('/updateUser/{id}',ModifierInfosUtilisateurAction::class)->setName("getUpdateUser");
    $app->post('/updateUser/{id}',ModifierInfosUtilisateurAction::class)->setName("postUpdateUser");

    //voir son compte
    $app->get('/monCompte/{id}',MonCompteAction::class)->setName("getMonCompte");
    $app->post('/monCompte/{id}',MonCompteAction::class)->setName("postMonCompte");

    //remove User
    $app->get('/removeUser/{id}',GalerieRemoveUserAction::class)->setName("getGalerieRemoveUser");
    $app->post('/removeUser/{id}',GalerieRemoveUserAction::class)->setName("postGalerieRemoveUser");
    
    //leave galerie
    $app->get('/leaveGalerie/{id}',GalerieLeaveGalerieAction::class)->setName("getGalerieLeaveUser");
    $app->post('/leaveGalerie/{id}',GalerieLeaveGalerieAction::class)->setName("postGalerieLeaveUser");

    // display photo
    $app->get('/img/{id}',AfficherPhotoAction::class)->setName("getImage");
    
    //delete photo
    $app->get('/photoDelete/{id}',DeletePhotoAction::class)->setName("getPhotoDelete");
    $app->post('/photoDelete/{id}',DeletePhotoAction::class)->setName("postPhotoDelete");
    
    //update photo
    $app->get('/photoUpdate/{id}',UpdatePhotoAction::class)->setName("getPhotoUpdate");
    $app->post('/photoUpdate/{id}',UpdatePhotoAction::class)->setName("postPhotoUpdate");
    //send comment
    $app->get('/sendMessage/{id}', CommentaireAction::class)->setName("getMessage");
    $app->post('/sendMessage/{id}', CommentaireAction::class)->setName("postMessage");

    //groupes
    $app->get('/group/{id}', AfficherGroupeAction::class)->setName("getGroupe");
    $app->get('/creerGroup/{id}', CreerGroupeAction::class)->setName("GetCreerGroupe");
    $app->post('/creerGroup/{id}', CreerGroupeAction::class)->setName("PostCreerGroupe");

    //add user to groupe
    $app->get('/ajouterMembresGroupe/{id}', AjouterMembresGroupeAction::class)->setName("GetAjouterMembresGroupe");
    $app->post('/ajouterMembresGroupe/{id}', AjouterMembresGroupeAction::class)->setName("PostAjouterMembresGroupe");

    //supprimer groupe
    $app->get('/supprimerGroupe/{id}', DeleteGroupAction::class)->setName("getDeleteGroup");
    $app->post('/supprimerGroupe/{id}', DeleteGroupAction::class)->setName("postDeleteGroup");

    //delete user to groupe
    $app->get('/deleteUserGroupe/{id_g}/{id_u}', GroupeRemoveUserAction::class)->setName("getGroupeUserDelete");
    $app->post('/deleteUserGroupe/{id_g}/{id_u}', GroupeRemoveUserAction::class)->setName("postGroupeUserDelete");

    //delete comment
    $app->get('/deleteMessage/{id}', DeleteCommentaireAction::class)->setName("getMessageDelete");
    $app->post('/deleteMessage/{id}', DeleteCommentaireAction::class)->setName("postMessageDelete");

    //ajout groupe à une galerie
    $app->get('/addGroup/{id}', GalerieAddGroupeAction::class)->setName("getGalerieAddGroup");
    $app->post('/addGroup/{id}', GalerieAddGroupeAction::class)->setName("postGalerieAddGroup");

    //Suppression d'un groupe d'une galerie
    $app->get('/deleteGroup/{id}', GalerieRemoveGroupeAction::class)->setName("getGalerieRemoveGroup");
    $app->post('/deleteGroup/{id}', GalerieRemoveGroupeAction::class)->setName("postGalerieRemoveGroup");
};
