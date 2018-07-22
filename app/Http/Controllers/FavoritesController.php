<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
       // a reply can be favorited
        return $reply->favorite();


//        Favorite::create([
//            'user_id' => auth()->user()->id,
//            'favorited_id' => $reply->id,
//            'favorited_type' => get_class($reply)
//        ]);
    }
}
