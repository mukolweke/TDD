<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        // create a thread
        $this->thread = factory('App\Thread')->create();
    }


    /** @test **/
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);

    }

    /** @test **/
    public function a_user_can_read_a_single_threads()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }


    /** @test  **/
    public function a_user_can_read_replies_that_are_associated_with_a_thread(){


        // thread has replies
        $reply = factory('App\Reply')
            ->create(['thread_id'=> $this->thread->id]);



        // when we visit the thread page then we  should see replies
       $this->get($this->thread->path())
           ->assertSee($reply->body);


    }
}
