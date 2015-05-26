<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

    protected $fillable = [
        'poll_id',
        'slack_user_id',
        'selection',
    ];

    protected $casts = [
        'selection' => 'int'
    ];

    public function poll() {
        return $this->belongsTo('App\Poll');
    }

}
