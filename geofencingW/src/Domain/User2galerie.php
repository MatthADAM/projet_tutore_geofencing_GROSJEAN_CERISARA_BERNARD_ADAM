<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class User2Galerie extends Model
{
    protected $table = 'user_2_galerie';
    protected $primaryKey = ['id_user','id_galerie'];
    public $timestamps = false;
    public $incrementing = false;

    public static function create($id_user,$id_galerie,$acces){
        // Variables
        $user2Galerie= new User2Galerie();
        $user2Galerie->id_user=$id_user;
        $user2Galerie->id_galerie=$id_galerie;
        $user2Galerie->acces=$acces;
        // enregistrement dans la table
        $user2Galerie->save();
        return $user2Galerie;
    }
    public function galeries(){
        return $this->hasOne('/App/Domain/Galerie', 'id_galerie','id_galerie');
    }
    public function user(){
        return $this->hasOne('/App/Domain/User', 'id_user','id_user');
    }
    protected function getKeyForSaveQuery()
    {

        $primaryKeyForSaveQuery = array(count($this->primaryKey));

        foreach ($this->primaryKey as $i => $pKey) {
            $primaryKeyForSaveQuery[$i] = isset($this->original[$this->getKeyName()[$i]])
                ? $this->original[$this->getKeyName()[$i]]
                : $this->getAttribute($this->getKeyName()[$i]);
        }

        return $primaryKeyForSaveQuery;

    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {

        foreach ($this->primaryKey as $i => $pKey) {
            $query->where($this->getKeyName()[$i], '=', $this->getKeyForSaveQuery()[$i]);
        }

        return $query;
    }
}