# Crab web application

A starting point for a web application on the [Crab framework](https://github.com/crabphp/framework): pages a browser loads, rendered on the server. It comes with three packages wired in, and a small notes board that uses each:

- [Arc](https://github.com/crabphp/arc) renders `resources/views`: layouts and typed components, compiled to PHP closures.
- Sessions keep a visit's temporary data, such as the message shown after a form.
- [Tide](https://github.com/crabphp/tide) reads and saves models, such as `app/Note.php`.

For a JSON API with none of these, start from [crabphp/crab](https://github.com/crabphp/crab) instead.

## Start

~~~sh
composer create-project crabphp/crab-web shop
cd shop
php cua dev
~~~

`create-project` copies `.env.example` to `.env`, writes a new secret, `APP_KEY`, into it with `php cua key:generate`, and creates the notes table with `php cua migrate`. From a clone of this repository instead, run `composer install`, `cp .env.example .env`, `php cua key:generate` and `php cua migrate` before `php cua dev`.

Open http://127.0.0.1:8080 and add a note. The server restarts when you save a file, a template included. `php cua` lists every command, `php cua describe` prints the whole application for coding agents, and `composer test` runs the tests.

It needs PHP 8.4 with `mbstring`, `pdo_sqlite`, `pcntl` and `posix`. Development also needs `dom` and `xmlwriter`, for PHPUnit, which runs the tests; `create-project` checks for them even with `--no-dev`. A production install, `composer install --no-dev`, does not.

## On Windows

Develop inside WSL 2, not in PowerShell or the Command Prompt: the server uses PHP's `pcntl` and `posix` extensions, which PHP for Windows does not have. In PowerShell opened as administrator, run `wsl --install` and restart Windows. Then, in the Ubuntu terminal it installs:

~~~sh
sudo apt update
sudo apt install -y software-properties-common
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
sudo apt install -y php8.4-cli php8.4-mbstring php8.4-xml php8.4-sqlite3 unzip
~~~

Install Composer from [getcomposer.org/download](https://getcomposer.org/download/) and move it into place with `sudo mv composer.phar /usr/local/bin/composer`. Then run the commands under [Start](#start) from your Linux home folder (`cd ~`), not from `/mnt/c`, and open http://localhost:8080 in your browser on Windows.

[Developing on Windows](https://github.com/crabphp/framework/blob/main/docs/installation.md#developing-on-windows) in the framework's guide explains each step.

## Where things are

~~~text
app.php                      describes the application: plugins, routes, middleware
routes/web.php               HTTP routes
routes/console.php           your commands
app/Actions/                 route actions as classes: ShowNotes renders the page, AddNote saves the form
app/Http/                    input classes, the forms' fields and their rules
app/Note.php                 a Tide model, a row of the notes table
app/Setup.php                your services
resources/views/             Arc templates; notes.arc.php is the page
resources/views/components/  components: <Layout>, <NoteCard>, <Input>, <Button>, <Flash>
database/migrations/         the tables
config/                      settings, read from .env; config('file.key') reads one
storage/                     logs and the SQLite file; never committed
tests/                       tests that send the application requests, without a server
AGENTS.md                    the conventions, for coding agents
~~~

## Making things

| To add | Run |
| --- | --- |
| A command | `php cua make:command PruneUsers`, which writes it and registers it as `user:prune` |
| Middleware | `php cua make:middleware RequireAdmin` |
| A table | `php cua make:migration create_posts_table`, then `php cua migrate`; `php cua migrate:fresh` starts the database over |
| A setting the framework has | `php cua config:publish server` writes every server setting, at its default |

The database is SQLite in `storage/database.sqlite` until you set `DB_DRIVER=mysql` and `DB_DATABASE` (with `DB_HOST`, `DB_USERNAME` and `DB_PASSWORD`) in `.env`.

## In production

~~~text
APP_DEBUG=false
APP_URL=https://example.com
SERVER_WORKERS=4
~~~

Give production its own `APP_KEY` (`php cua key:generate --show` prints one) and serve it over HTTPS: the session cookie is sent over HTTPS only, which browsers relax for `127.0.0.1` and `localhost` while developing. To develop over plain HTTP at another address, set `session.secure` to `false` in a `config/session.php` that only your machine uses. Compile the templates and migrate when deploying, then `php cua start --daemon`, with `php cua view:cache`, `php cua migrate` and `php cua reload` after each deploy, and `php cua stop` to stop. See [Deployment](https://github.com/crabphp/framework/blob/main/docs/deployment.md).

## The guide

Every topic has a page in [the framework's guide](https://github.com/crabphp/framework/blob/main/docs/documentation.md), which comes with it too, in `vendor/crabphp/framework/docs/`.
