<?php

namespace App\Commands;

use App\Events\DemoEvent;
use Myerscode\Acorn\Framework\Console\Command;

use function Myerscode\Acorn\Foundation\bag;
use function Myerscode\Acorn\Foundation\config;
use function Myerscode\Acorn\Foundation\emit;

class DemoCommand extends Command
{

    protected string $signature = 'demo';

    protected string $description = 'A demo command.';

    public function handle(): void
    {
        emit(DemoEvent::class, time() + rand(0, 1000));

        $corgis = config('demo.corgis');

        $names = bag($corgis)->join(', ', ' and ');

        $corgiCount = count($corgis);

        $this->output->writeln("There are $corgiCount Corgis in Demo Config - their names are $names!");
    }
}
