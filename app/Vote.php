<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

    protected $fillable = ['poll_id', 'user_id', 'selection'];

    protected $casts = [
        'selection' => 'int'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function poll() {
        return $this->belongsTo('App\Poll');
    }

}
