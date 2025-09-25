<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportEntitiesJob;

class ImportEntitiesCommand extends Command
{
    protected $signature = 'import:entities';
    protected $description = 'Importa entidades do arquivo CSV para o banco de dados';
    public function handle()
    {
        $this->info('Iniciando importação...');
        // Substitua dispatch_now por dispatch_sync
        dispatch_sync(new ImportEntitiesJob());

        $this->info('Importação finalizada.');
    }
}
