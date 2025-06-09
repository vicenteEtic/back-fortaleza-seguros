<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeFullModuleCommand extends Command
{
    protected $signature = 'make:module {name} {--m} {--r} {--s} {--c}';
    protected $description = 'Cria model, repositories, controller e service para um módulo automaticamente usando o nome como caminho.';

    public function handle()
    {
        $name = $this->argument('name');

        // Extrai path e filename da função
        [$path, $filename] = $this->getPathAndFilename($name);

        // Cria os arquivos de acordo com as flags passadas
        if ($this->option('m')) {
            $this->createModel($path, $filename);
        }

        if ($this->option('r')) {
            $this->createRepository($path, $filename);
        }

        if ($this->option('s')) {
            $this->createService($path, $filename);
        }

        if ($this->option('c')) {
            $this->createController($path, $filename);
        }

        $this->info('Arquivos criados com sucesso!');
    }

    protected function getPathAndFilename($name)
    {
        // Detecta se há separadores (\ ou /) no nome
        $segments = preg_split('/[\/\\\\]+/', $name);

        // O último elemento é o nome do arquivo (classe)
        $filename = array_pop($segments);

        // O restante é o caminho dos diretórios
        $path = implode(DIRECTORY_SEPARATOR, $segments);

        return [$path, $filename];
    }

    protected function createModel($path, $filename)
    {
        $modelTemplate = "<?php

namespace App\Models\\{$path};

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class $filename extends BaseModel
{
    use HasFactory;
}";

        $directory = app_path("/Models/{$path}");
        File::ensureDirectoryExists($directory);
        File::put("$directory/{$filename}.php", $modelTemplate);

        $this->info("Model $filename criado em $directory");
    }

    protected function createRepository($path, $filename)
    {
        $repositoryTemplate = "<?php
namespace App\Repositories\\{$path};

use App\Models\\{$path}\\{$filename};
use App\Repositories\AbstractRepository;

class {$filename}Repository extends AbstractRepository
{
    public function __construct({$filename} \$model)
    {
        parent::__construct(\$model);
    }
}";

        $directory = app_path("/Repositories/{$path}");
        File::ensureDirectoryExists($directory);
        File::put("$directory/{$filename}Repository.php", $repositoryTemplate);

        $this->info("Repository $filename criado em $directory");
    }

    protected function createService($path, $filename)
    {
        $serviceTemplate = "<?php
namespace App\Services\\{$path};

use App\Repositories\\{$path}\\{$filename}Repository;
use App\Services\AbstractService;

class {$filename}Service extends AbstractService
{
    public function __construct({$filename}Repository \$repository)
    {
        parent::__construct(\$repository);
    }
}";

        $directory = app_path("/Services/{$path}");
        File::ensureDirectoryExists($directory);
        File::put("$directory/{$filename}Service.php", $serviceTemplate);

        $this->info("Service $filename criado em $directory");
    }

    protected function createController($path, $filename)
    {
        $controllerTemplate = "<?php

namespace App\Http\Controllers\\{$path};

use App\Http\Controllers\AbstractController;
use App\Services\\{$path}\\{$filename}Service;
use Exception;
use Illuminate\Http\Response;

class {$filename}Controller extends AbstractController
{
    public function __construct({$filename}Service \$service)
    {
        \$this->service = \$service;
    }
}";

        $directory = app_path("/Http/Controllers/{$path}");
        File::ensureDirectoryExists($directory);
        File::put("$directory/{$filename}Controller.php", $controllerTemplate);

        $this->info("Controller $filename criado em $directory");
    }
}
