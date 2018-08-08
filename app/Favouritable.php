<?php
/**
 * Created by PhpStorm.
 * User: molukaka
 * Date: 07/08/2018
 * Time: 07:27
 */

namespace App;


trait Favouritable
{
    public function favourites()
    {
        return $this->morphMany('App\Favorite', 'favorited');
    }

    public function favourite()
    {
        $attributes = ['user_id'=>auth()->id()];

        if(! $this->favourites()->where($attributes)->exists())
        {
            return $this->favourites()->create($attributes);
        }
    }

    public function isFavorited()
    {
        return !! $this->favourites()->where('user_id', auth()->id())->count();
    }

    /**
     * @return mixed
     */
    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }
}