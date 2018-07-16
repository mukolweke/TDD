<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ThreadsTest extends TestCase
{

    use DatabaseMigrations;

    /**@test**/
    public function test_a_user_can_view_all_threads()
    {
        //create a thread
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads');
        $response->assertSee($thread->title);

    }

    /**@test**/
    public function test_a_user_can_view_a_single_threads()
    {
        //create a thread
        $thread = factory('App\Thread')->create();


        $response = $this->get('/threads/' .$thread->id);
        $response->assertSee($thread->title);
    }
}
