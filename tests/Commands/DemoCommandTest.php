<?php

declare(strict_types=1);

namespace Tests\Commands;

use App\Events\DemoEvent;
use App\Listeners\DemoListener;
use Myerscode\Acorn\Foundation\Console\Display\DisplayOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\BaseTestCase;

final class DemoCommandTest extends BaseTestCase
{
    public function testOutputsTheCorgisFromConfig(): void
    {
        // app/Config/Demo.php is loaded automatically by the test harness, so
        // no manual config override is needed. Corgis: Gerald and Rupert.
        $this->runCommand('demo', ['--greeter' => 'Arthur'])
            ->assertSuccessful()
            ->assertOutputContains('There are 2 Corgis')
            ->assertOutputContains('Gerald and Rupert')
            ->assertOutputContains('Welcome, Arthur!');
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
