<?php

namespace App\Console\Commands;

use App\Jobs\GestaoAlertaJob;
use Illuminate\Console\Command;

class GerarAlertaPepCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gerar-alerta-pep-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        GestaoAlertaJob::dispatch();
    }
}
