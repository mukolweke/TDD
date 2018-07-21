<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


/**
 * @property  thread
 */
class ReplyTest extends TestCase
{

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        // create a thread
        $this->thread = create('App\Thread');
    }


    /** @test **/
    public function a_user_can_view_all_threads()
    {
//        dd('mike');
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);

    }

    /** @test **/
    public function a_user_can_view_a_single_threads()
    {
//        dd($this->thread->path().$this->thread->id);
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
