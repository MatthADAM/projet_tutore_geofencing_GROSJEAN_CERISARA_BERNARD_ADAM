<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Informations extends Model
{
    protected $table = 'informations';
    protected $primaryKey = 'id_info';
    public $timestamps = false ;

    public static function create($id_zone, $type, $contenu){
        // Variables
        $infos = new Informations();
        $infos->id_zone = $id_zone;
        $infos->type = $type;
        $infos->contenu = $contenu;
        // enregistrement dans la table
        $infos->save();
    }
}