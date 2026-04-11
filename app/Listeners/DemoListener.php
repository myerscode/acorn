<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\DemoEvent;
use Myerscode\Acorn\Foundation\Console\Display\DisplayOutput as Output;
use Myerscode\Acorn\Framework\Events\Listener;
use Override;

class DemoListener extends Listener
{
    #[Override]
    protected string|array $listensFor = DemoEvent::class;

    public function __construct(protected Output $output)
    {
        //
    }

    public function __invoke(DemoEvent $demoEvent): void
    {
        $this->output->info(DemoEvent::class . ' event emitted on ' . date('jS F Y \a\t H:i:s', $demoEvent->timestamp));
    }
}
