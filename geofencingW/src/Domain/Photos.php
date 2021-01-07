<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Photos extends Model
{
    protected $table = 'photos';
    protected $primaryKey = 'id_photo';
    public $timestamps = false ;

    public static function create($id_galerie,$titre,$imageUrl,$motcles){
        // Variables
        $photo= new Photos();
        $photo->id_galerie = $id_galerie;
        $photo->titre=$titre;
        $photo->imageUrl = $imageUrl;
        $photo->motscles = $motcles;
        $photo->date = date("Y-m-d H:i:s");
        // enregistrement dans la table
        return $photo->save();
        // retourne le tuple créé
    }
    public function galeries(){
        return $this->belongsTo('/App/Domain/Galerie', 'id_galerie', 'id_galerie');
    }

}