<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $fillable = ['slack_id', 'name'];

    public function votes() {
        return $this->hasMany('App\Vote');
    }

    public function polls() {
        return $this->hasMany('App\Poll');
    }

    public function scopeGetSlackId($query, $user_id)
    {
        return $query->findOrNew([
            'slack_user_id'   => $user_id
        ])->id;
    }

}
