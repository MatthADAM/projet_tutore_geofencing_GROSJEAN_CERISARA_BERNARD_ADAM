<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Point_2_Zone extends Model
{
    protected $table = 'point_2_zone';
    protected $primaryKey = 'id_point';
    public $timestamps = false ;

    public static function create($id_point, $id_zone){
        // Variables
        $point_2_zone = new Point_2_Zone();
        $point_2_zone->id_point = $id_point;
        $point_2_zone->id_zone = $id_zone;
        // enregistrement dans la table
        $point_2_zone->save();
    }
}