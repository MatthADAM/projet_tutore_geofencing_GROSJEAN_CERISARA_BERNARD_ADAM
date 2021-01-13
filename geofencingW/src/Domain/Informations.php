<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Informations extends Model
{
    protected $table = 'zone';
    protected $primaryKey = 'id_zone';
    public $timestamps = false ;

    public static function create($nom, $description){
        // Variables
        $zone = new Zone();
        $zone->nom = $nom;
        $zone->description = $description;
        // enregistrement dans la table
        $zone->save();
    }
}