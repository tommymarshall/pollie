<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model {

    protected $fillable = ['user_id', 'name', 'password', 'options', 'active'];

    protected $casts = [
        'options' => 'json',
        'active'  => 'bool',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function votes() {
        return $this->hasMany('App\Vote');
    }

}
