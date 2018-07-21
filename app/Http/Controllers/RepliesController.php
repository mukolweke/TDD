<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');

    }


    public function store($channelId, Thread $thread){

        // add reply
        $thread-> addReply([
            'body'=> request('body'),
            'user_id' => auth()->id()
        ]);
        // redirect
        return redirect($thread->path());
    }


}
