<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Galerie extends Model
{
    protected $table = 'galerie';
    protected $primaryKey = 'id_galerie';
    public $timestamps = false ;

    public static function create($nom,$type,$desc,$motscles){
        // Variables
        $galerie= new Galerie();
        $galerie->nom = $nom;
        $galerie->type=$type;
        $galerie->description = $desc;
        $galerie->motscles = $motscles;
        $galerie->date = date("Y-m-d H:i:s");
        // enregistrement dans la table
        $galerie->save();
        return $galerie;
        // retourne le tuple créé
    }
    public function users(){
        return $this->hasManyThrough('\App\Domain\User', '\App\Domain\User2galerie', 'id_galerie', 'id_user', 'id_galerie', 'id_user');
    }
    public function user2galerie(){
        return $this->hasMany('\App\Domain\User2galerie');
    }

    public function photos(){
        return $this->hasMany('\App\Domain\Photos');
    }

}