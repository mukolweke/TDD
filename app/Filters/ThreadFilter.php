<?php
/**
 * Created by PhpStorm.
 * User: molukaka
 * Date: 22/07/2018
 * Time: 16:42
 */

namespace App\Filters;

use App\User;

class ThreadFilter extends Filters
{
    protected $filters = ['by', 'popular'];


//    filter a query by the username
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrfail();

        return $this->builder->where('user_id', $user->id);
    }

    /*
     *
     * filter query according to popular threads
     *
     */
    protected function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    protected function unanswered()
    {
        return $this->builder->where('replies_count', '0');
    }

}