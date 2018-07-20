<?php /** @noinspection ALL */

namespace Tests\Unit;

use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;

//    protected $thread;

    public function setUp()
    {
        parent::setUp();

        // create a thread
        $this->thread = create('App\Thread');
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function a_thread_has_replies(){

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);

    }

    /** @test **/
    function a_thread_has_a_creator(){

        $this->assertInstanceOf('App\User',$this->thread->creator);

    }

    /** @test **/
    function a_thread_can_add_a_reply(){

        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id'=>1
        ]);

        // thread reply relationship ...
        $this->assertCount(1, $this->thread->replies);

    }
}
