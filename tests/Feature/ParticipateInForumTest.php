<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;


    protected $thread;

    function unauthenticated_user_may_not_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', []);
    }


    /** @test */

    function an_authenticated_user_may_participate_in_forum()
    {
        // authenticated user, existing thread.
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        // user adds a reply to thread
        $reply = factory('App\Reply')->make();
//dd($thread->path() . $thread->id );
        $this->get($thread->path() . $thread->id . '/replies', $reply->toArray());

        // reply visible
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
