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
        $this->signIn();

        $thread = create('App\Thread');

        // user adds a reply to thread
        $reply = make('App\Reply');

        $this->post($thread->path() . $thread->id . '/replies', $reply->toArray());

        // reply visible
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
