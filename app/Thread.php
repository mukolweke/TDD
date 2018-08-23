<?php

namespace App;

use function foo\func;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Thread $thread){
            $thread->replies->each->delete();
        });
    }


    public function path()
    {
        return "/threads/{$this->channel->slug }/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    function addReply($reply)
    {
        return $this->replies()->create($reply);
    }

    function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    function subscribe($userId)
    {
        $this->subscriptions()->create([
            'user_id'=> $userId ?: auth()->id()
        ]);
    }

    function unsubscribe($userId)
    {
        $this->subscriptions()
            ->where('user_id',  $userId ?: auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }


}
