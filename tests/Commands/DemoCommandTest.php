<?php

declare(strict_types=1);

namespace Tests\Commands;

use App\Events\DemoEvent;
use App\Listeners\DemoListener;
use Myerscode\Acorn\Foundation\Console\Display\DisplayOutput;
use Myerscode\Acorn\Testing\Interactions\InteractsWithCommands;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\BaseTestCase;

final class DemoCommandTest extends BaseTestCase
{
    use InteractsWithCommands;

    protected function setUp(): void
    {
        parent::setUp();

        // The test harness loads core framework config but not the skeleton's
        // app/Config, so provide the demo config the command reads. Mirrors
        // app/Config/Demo.php.
        $this->application()->container()->get('config')->store()->set('demo', ['corgis' => ['Gerald', 'Rupert']]);
    }

    public function testOutputsTheCorgisFromConfig(): void
    {
        $output = $this->call('demo');

        // The demo reads two corgis (Gerald, Rupert) from app/Config/Demo.php.
        $this->assertStringContainsString('There are 2 Corgis', $output);
        $this->assertStringContainsString('Gerald and Rupert', $output);
    }

    public function testTheEventListenerHandlesTheEvent(): void
    {
        // Regression guard: the demo listener previously implemented
        // __invoke() instead of handle(), so the dispatcher (which calls
        // handle()) never ran it and the emitted-event line was silently
        // missing, making events look broken. Invoke handle() directly so the
        // guard does not depend on listener-discovery plumbing.
        $buffer = new BufferedOutput();
        $display = new DisplayOutput(new ArrayInput([]), $buffer);

        new DemoListener($display)->handle(new DemoEvent(1_700_000_000));

        $this->assertStringContainsString('event emitted on', $buffer->fetch());
    }
}
