<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Reverb\Contracts\Logger;
use Laravel\Reverb\Loggers\CliLogger;
use Laravel\Reverb\Servers\Reverb\Console\Commands\StartServer;

class WebsocketStart extends StartServer
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:start
                {--host= : The IP address the server should bind to}
                {--port= : The port the server should listen on}
                {--path= : The path the server should prefix to all routes}
                {--hostname= : The hostname the server is accessible from}
                {--debug : Indicates whether debug messages should be displayed in the terminal}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        if (env('REVERB_DEBUG', false)) {
            $this->laravel->instance(Logger::class, new CliLogger($this->output));
            $this->info( 'debug enabled');
        }

        parent::handle();
    }
}
