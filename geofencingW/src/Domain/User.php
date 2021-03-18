<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false ;

    public static function create($email, $password, $admin){
        // Variables
        $user = new User();
        $user->email = $email;
        $user->password = $password;
        $user->admin = $admin;
        // enregistrement dans la table
        $user->save();
        // retourne le tuple créé
        return User::Where("email", "=", $email)->first();
    }
}