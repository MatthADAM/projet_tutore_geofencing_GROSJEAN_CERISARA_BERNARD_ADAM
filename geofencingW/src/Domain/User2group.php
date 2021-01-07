<?php


namespace App\Domain;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class User2group extends Model
{
    protected $table = 'user_2_group';
    protected $primaryKey = ['id_user','id_group'];
    public $timestamps = false;
    public $incrementing = false;

    public static function create($id_group,$id_user){
        // Variables
        $user2Group= new User2Group();
        $user2Group->id_group=$id_group;
        $user2Group->id_user=$id_user;
        // enregistrement dans la table
        $user2Group->save();
        return $user2Group;
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