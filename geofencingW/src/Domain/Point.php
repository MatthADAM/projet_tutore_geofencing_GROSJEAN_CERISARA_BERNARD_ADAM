<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'point';
    protected $primaryKey = 'id_point';
    public $timestamps = false ;

    public static function create($x, $y){
        // Variables
        $point = new Point();
        $point->x = $x;
        $point->y = $y;
        // enregistrement dans la table
        $point->save();
    }
}