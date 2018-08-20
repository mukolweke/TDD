<?php

namespace Tests\Feature;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $oldExceptionHandler;


    protected function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();
    }

    /** @test */
    function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();


        $this->post('/threads')
            ->assertRedirect('/login');


        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_thread()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))     // then visit thread page
            ->assertSee($thread->title) // see new thread
            ->assertSee($thread->body);
    }


    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }

    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThreads(['title'=>null])
            ->assertSessionHasErrors('title');

    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThreads(['body'=>null])
            ->assertSessionHasErrors('body');

    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel',2)->create();

        $this->publishThreads(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThreads(['channel_id'=>999])
            ->assertSessionHasErrors('channel_id');

    }

    /** @test */
    public function unauthorized_users_nay_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path())->assertStatus(403);

    }


    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread',['user_id'=>auth()->id()]);
        $reply = create('App\Reply',['thread_id'=> $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }


    public function publishThreads($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread',$overrides);

        return $this->post('/threads', $thread->toArray());
    }

}
