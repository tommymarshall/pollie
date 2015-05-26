<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model {

    protected $fillable = [
        'name',
        'pin',
        'slack_user_id',
        'slack_channel_id',
        'slack_channel_name',
        'options',
        'active',
    ];

    protected $casts = [
        'options' => 'json',
        'active'  => 'bool',
    ];

    public function votes() {
        return $this->hasMany('App\Vote');
    }

    public function scopeActiveChannel($query, $channel_id = "*")
    {
        return $query->where('active', true)
                     ->where('slack_channel_id', $channel_id);
    }

    public function scopeResultsFor($query, $channel_id)
    {
        return $query->find($channel_id)
                     ->with(['votes']);
    }
}
