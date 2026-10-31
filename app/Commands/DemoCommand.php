<?php

declare(strict_types=1);

namespace App\Commands;

use App\Events\DemoEvent;
use Myerscode\Acorn\Framework\Console\Command;
use Override;

use function Myerscode\Acorn\Foundation\bag;
use function Myerscode\Acorn\Foundation\config;
use function Myerscode\Acorn\Foundation\emit;

/**
 * A tour of Acorn's building blocks: config, events, progress bars and
 * prompts. Run `php acorn demo` to see it, or `php acorn demo --no-interaction`
 * (the default in CI) to skip the questions.
 *
 * Use this as a starting point and replace it with your own commands.
 */
class DemoCommand extends Command
{
    #[Override]
    protected string $description = 'A guided tour of Acorn features.';

    #[Override]
    protected string $signature = 'demo {--greeter= : Who is running the demo}';

    public function handle(): int
    {
        // 1. Events — emit an event; see app/Listeners/DemoListener.php.
        emit(DemoEvent::class, time());

        // 2. Config — values come from app/Config/Demo.php.
        /** @var string[] $corgis */
        $corgis = config('demo.corgis', []);
        $names = bag($corgis)->join(', ', ' and ');

        $this->output->writeln(sprintf('There are %d Corgis in Demo Config - their names are %s!', count($corgis), $names));

        // 3. Prompts — ask interactively, with a sensible default so the
        //    command still runs under --no-interaction and in tests.
        $greeter = $this->option('greeter') ?: $this->ask('Who are you?', 'a friend');
        $this->output->writeln(sprintf('Welcome, %s!', $greeter));

        // 4. Progress — show a progress bar walking the corgis.
        if ($corgis !== []) {
            $this->withProgressBar($corgis, function (string $corgi): void {
                usleep(50_000); // pretend to do work
            });
            $this->output->writeln('');
        }

        return 0;
    }
}
