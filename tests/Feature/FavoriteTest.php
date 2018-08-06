<?php
/**
 * Created by PhpStorm.
 * User: molukaka
 * Date: 22/07/2018
 * Time: 17:26
 */

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function guest_can_not_favourite_any_reply()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');

    }


    /** @test */
    public function an_authenticated_user_can_favourite_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/'. $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }


    /** @test */
    public function an_authenticated_user_may_favorite_only_once()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try{
            $this->post('replies/'. $reply->id . '/favorites');
            $this->post('replies/'. $reply->id . '/favorites');
        }catch (\Exception $e){
            $this->fail('Did not expect to insert same record twice');
        }
        $this->assertCount(1, $reply->favorites);

    }
}