<?php /** @noinspection ALL */

namespace Tests\Unit;

use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        // create a thread
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test **/
    function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User',$this->thread->creator);
    }

    /** @test **/
    function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id'=>1
        ]);

        // thread reply relationship ...
        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel',$thread->channel);
    }


    /** @test */
    function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }
}
