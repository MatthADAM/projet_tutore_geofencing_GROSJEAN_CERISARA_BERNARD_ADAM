<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zone';
    protected $primaryKey = 'id_zone';
    public $timestamps = false ;

    public static function create($nom, $description, $id_user){
        // Variables
        $zone = new Zone();
        $zone->nom = $nom;
        $zone->description = $description;
        $zone->id_user = $id_user;
        // enregistrement dans la table
        $zone->save();
    }
}