<?php

namespace Test\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function a_user_can_subcribe_to_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');


        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);

        $this->assertCount(1, auth()->user()->notifications());

        /*
         each time a reply, update is done to the thread a notification
        should be preapred for the user*/


    }
}