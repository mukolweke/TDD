<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Events\ThreadReceivedNewReply;
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

        event(new ThreadHasNewReply($this, $reply));

//        $this->notifySubscribers($reply);

        return $reply;

    }

    public function notifySubscribers($reply){
        $this->subscriptions
            ->where('user_id'.'!='. $reply->user_id )
            ->each
            ->notify($reply);
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

    /**
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function hasUpdatesFor($user)
    {
//        look in cache for a proper key
        $key = $user->visitedThreadCacheKey($this);

        // compare the carbon instance with the thread->updated_at
        return $this->updated_at > cache($key);
    }

}
