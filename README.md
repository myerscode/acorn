[![Latest Stable Version](https://poser.pugx.org/myerscode/acorn/v/stable)](https://packagist.org/packages/myerscode/acorn)
[![Total Downloads](https://poser.pugx.org/myerscode/acorn/downloads)](https://packagist.org/packages/myerscode/acorn)
[![PHP Version Require](http://poser.pugx.org/myerscode/acorn/require/php)](https://packagist.org/packages/myerscode/acorn)
[![License](https://poser.pugx.org/myerscode/acorn/license)](https://github.com/myerscode/acorn/blob/main/LICENSE)
[![Tests](https://github.com/myerscode/acorn/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/myerscode/acorn/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/myerscode/acorn/graph/badge.svg)](https://codecov.io/gh/myerscode/acorn)

# Acorn

> A skeleton for building powerful PHP CLI applications with [Acorn](https://github.com/myerscode/acorn-framework).

This is the starting point for a new Acorn app. Clone it, and you have a working
CLI with an example command, event, listener and config to learn from.

## Requirements

- PHP 8.5 or higher

## Creating a new project

```bash
composer create-project myerscode/acorn my-app --remove-vcs
cd my-app
php acorn
```

`php acorn` lists the available commands. Try the guided demo:

```bash
php acorn demo
```

## Project structure

```
app/
  Commands/    # your commands (auto-discovered)
  Config/      # config files, read via config('file.key')
  Events/      # event classes
  Listeners/   # listeners, auto-wired to the events they listensFor()
acorn            # the executable entry point
```

## Your first command

Create `app/Commands/GreetCommand.php` (or scaffold it with
[acorn-cli](https://github.com/myerscode/acorn-cli): `acorn-cli make:command greet`):

```php
<?php

namespace App\Commands;

use Myerscode\Acorn\Framework\Console\Command;

class GreetCommand extends Command
{
    protected string $signature = 'greet {name} {--loud}';

    protected string $description = 'Greet someone';

    public function handle(): int
    {
        $greeting = 'Hello ' . $this->argument('name');

        $this->output->writeln($this->flag('loud') ? strtoupper($greeting) : $greeting);

        return 0;
    }
}
```

```bash
php acorn greet Rupert --loud
```

## Explore the demo

`app/Commands/DemoCommand.php` is a guided tour that reads **config**, emits an
**event** (handled by `app/Listeners/DemoListener.php`), asks a **prompt**, and
renders a **progress bar**. Read it, then replace it with your own commands.

## Config

Files in `app/Config` are loaded automatically. `app/Config/Demo.php` returns an
array; read it with `config('demo.corgis')`.

## Events & listeners

Emit an event from anywhere with `emit(MyEvent::class, $payload)`. A listener in
`app/Listeners` that returns the event from `listensFor()` is wired up
automatically and its `handle()` runs when the event fires.

## Testing

The skeleton ships with [acorn-testing](https://github.com/myerscode/acorn-testing).
See `tests/` for examples:

```php
$this->runCommand('greet', ['name' => 'Rupert'])
    ->assertSuccessful()
    ->assertOutputContains('Hello Rupert');
```

## Optimising for production

Cache command/listener/provider discovery so boots skip the filesystem scan:

```bash
php acorn acorn:optimize   # run in your build/deploy step
php acorn acorn:clear      # drop the cache (e.g. in development)
```

## Issues

Bug reports and feature requests can be submitted on the [Github Issue Tracker](https://github.com/myerscode/acorn/issues).

## Contributing

Contributions are welcome! Please see [contributing.md](https://github.com/myerscode/docs/blob/master/contributing.md) for guidelines on how to contribute to this project.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
