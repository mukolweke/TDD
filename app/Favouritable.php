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
    protected static function bootFavouritable()
    {
        static::deleting(function ($model) {
            $model->favourites->each->delete();
        });
    }

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

    public function getFavoritesCountAttribute()
    {
        return $this->favourites->count();
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favourites()->where($attributes)->get()->each->delete();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
}