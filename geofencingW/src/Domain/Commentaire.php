<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaire';
    protected $primaryKey = 'id_commentaire';
    public $timestamps = false ;


    public static function create($id_photo, $id_user, $content, $date){
        // Variables
        $commentaire = new Commentaire();
        $commentaire->id_photo = $id_photo;
        $commentaire->id_user = $id_user;
        $commentaire->content = $content;
        $commentaire->date = $date;
        $commentaire->save();
        // retourne le tuple créé
        return $commentaire;
    }


}