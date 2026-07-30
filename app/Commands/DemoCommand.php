<?php

namespace App\Commands;

use App\Events\DemoEvent;
use Myerscode\Acorn\Framework\Console\Command;
use Override;

use function Myerscode\Acorn\Foundation\bag;
use function Myerscode\Acorn\Foundation\config;
use function Myerscode\Acorn\Foundation\emit;

class DemoCommand extends Command
{
    #[Override]
    protected string $description = 'A demo command.';

    #[Override]
    protected string $signature = 'demo';

    public function handle(): int
    {
        emit(DemoEvent::class, time() + random_int(0, 1000));

        $corgis = config('demo.corgis');

        $names = bag($corgis)->join(', ', ' and ');

        $corgiCount = count($corgis);

        $this->output->writeln(sprintf('There are %d Corgis in Demo Config - their names are %s!', $corgiCount, $names));

        return 0;
    }
}
