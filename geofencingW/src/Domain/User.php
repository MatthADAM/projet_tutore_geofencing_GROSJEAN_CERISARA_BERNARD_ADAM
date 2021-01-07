<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false ;

    public static function create($nom, $email, $password){
        // Variables
        $user = new User();
        $user->nom = $nom;
        $user->email = $email;
        $user->password = $password;
        // enregistrement dans la table
        $user->save();
        // retourne le tuple créé
        return User::Where("email", "=", $email)->first();
    }
    public function galeries() {

        return $this->hasManyThrough('\App\Domain\Galerie', '\App\Domain\User2galerie', 'id_user', 'id_galerie', 'id_user', 'id_galerie');
    }
    public function user2galerie()
    {
        return $this->hasMany('\App\Domain\User2galerie', 'id_user', 'id_user');
    }

}