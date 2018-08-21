<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');

    }


    public function store($channelId, Thread $thread){

        $this->validate(request(),[
            'body'=>'required'
        ]);
        // add reply
        $thread-> addReply([
            'body'=> request('body'),
            'user_id' => auth()->id()
        ]);
        // redirect
        return redirect($thread->path())
            ->with('flash', 'Your reply has been posted');
    }

    /**
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return back();
    }


}
