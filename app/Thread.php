<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use function foo\func;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator', 'channel'];
    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Thread $thread) {
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


    function subscribe($userId)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }

    /**
     * @param $reply
     * @return Model
     */
    function addReply($reply)
    {
        $reply = $this->replies()->create($reply);


        $this->subscriptions
            ->filter(function ($sub) use ($reply) {
                return $sub->user_id != $reply->user_id;
            })
            ->each->notify($reply); // higher order collections
//
//            ->each(function ($sub) use ($reply) {
//                $sub->user->notify(new ThreadWasUpdated($this, $reply));
//            });


        return $reply;
    }

    function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }


    function unsubscribe($userId)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }


}
