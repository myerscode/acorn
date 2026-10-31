<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\DemoEvent;
use Myerscode\Acorn\Foundation\Console\Display\DisplayOutput as Output;
use Myerscode\Acorn\Framework\Events\EventInterface;
use Myerscode\Acorn\Framework\Events\Listener;
use Override;

class DemoListener extends Listener
{
    public function __construct(protected Output $output)
    {
        //
    }

    /**
     * The dispatcher invokes handle() on a registered Listener; override it
     * (not __invoke) so the event actually runs this code.
     */
    #[Override]
    public function handle(EventInterface $event): void
    {
        if (!$event instanceof DemoEvent) {
            return;
        }

        $this->output->info(DemoEvent::class . ' event emitted on ' . date('jS F Y \a\t H:i:s', $event->timestamp));
    }

    #[Override]
    public function listensFor(): array|string
    {
        return DemoEvent::class;
    }
}
