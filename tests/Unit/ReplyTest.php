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

    use DatabaseMigrations;

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

}
