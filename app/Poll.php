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

    public function scopeActive($query, $channel_id)
    {
        return $query->where('active', true)
                     ->where('channel_id', $channel_id)
                     ->get();
    }

    public function scopeResultsFor($query, $channel_id)
    {
        return $query->find($id)
                     ->with(['votes'])
                     ->first();
    }

}
