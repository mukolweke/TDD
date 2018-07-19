<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_thread()
    {
        // given we have a signed user
        $this->actingAs(factory('App\User')->create());

        //hit endpoint to create a new thread
        $thread = factory('App\Thread')->make(); // return array, make/create object

        $this->post('/threads', $thread->toArray());


        $this->get($thread->path())     // then visit thread page
            ->assertSee($thread->title) // see new thread
            ->assertSee($thread->body);
    }

}
