<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $table = 'groupe';
    protected $primaryKey = 'id_group';
    public $timestamps = false ;

    public static function create($nom_group,$id_admin){
        // Variables
        $groupe= new Groupe();
        $groupe->nom_group = $nom_group;
        $groupe->id_admin = $id_admin;
        // enregistrement dans la table
        $groupe->save();
        return $groupe;
        // retourne le tuple créé
    }
    public function users(){
        return $this->hasMany('\App\Domain\User');
    }
    public function user2group(){
        return $this->hasMany('\App\Domain\User2group');
    }
}