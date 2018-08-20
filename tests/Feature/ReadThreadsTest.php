<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        // create a thread
        $this->thread = create('App\Thread');
    }


    /** @test * */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);

    }

    /** @test * */
    public function a_user_can_read_a_single_threads()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }


    /** @test  * */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // thread has replies
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        // when we visit the thread page then we  should see replies
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    function a_user_can_filter_threads_using_a_username()
    {
        $this->signIn(create('App\User', ['name' => 'mike']));

        $threadByMike = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByMike = create('App\Thread');

        $this->get('/threads?by=mike')
            ->assertSee($threadByMike->title)
            ->assertDontSee($threadNotByMike->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);



        $threadWithZeroReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        // return in order
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
