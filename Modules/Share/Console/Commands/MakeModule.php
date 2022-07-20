<?php

namespace Modules\Share\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $argument = $this->argument('name');
        $router = '$router';

        $pathServiceProvider = "<?php

namespace Modules\\$argument\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class {$argument}ServiceProvider extends ServiceProvider
{
    public string $/namespace = 'Modules\\$argument\Http\Controllers';

    public function register()
    {
        $/this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $/this->loadViewsFrom(__DIR__ . '/../Resources/Views/', '{$argument}');
        Route::middleware(['web', 'verify'])->namespace($/this->namespace)->group(__DIR__ . '/../Routes/{$argument}_routes.php');
    }
}
";
// -------------------------------------------------------------------------------------
        $pathRepo = "<?php

namespace Modules\\$argument\Repositories;

use Modules\Share\Contracts\Interface\RepositoriesInterface;
use Modules\Share\Repositories\ShareRepo;
use Modules\\$argument\Models\\$argument;

class {$argument}Repo implements RepositoriesInterface
{
    private string \$class = $argument::class;

    public function index()
    {

    }

    public function findById(\$id)
    {

    }

    public function delete(\$id)
    {

    }

    private function query()
    {
        return ShareRepo::query(\$this->class);
    }
}
";
        $route = "<?php

use Illuminate\Support\Facades\Route;

Route::group([], function ($router) {

});
        ";

        $service = "<?php

namespace Modules\\{$argument}\Services;

use Modules\Share\Contracts\Interface\ServicesInterface;
use Modules\\{$argument}\Models\\{$argument};
use Modules\Share\Repositories\ShareRepo;

class {$argument}Service implements ServicesInterface
{
    private string \$class = {$argument}::class;

    public function store(\$request)
    {
        return \$this->query()->create([

        ]);
    }

    public function update(\$request, \$id)
    {
        return \$this->query()->whereId(\$id)->update([

        ]);
    }

    private function query()
    {
        return ShareRepo::query(\$this->class);
    }
}
        ";

        File::makeDirectory('Modules/' . $argument);

        // Databases
        File::makeDirectory('Modules/' . $argument . '/Database');
        File::makeDirectory('Modules/' . $argument . '/Database/Migrations');

        // Providers
        File::makeDirectory('Modules/' . $argument . '/Providers');
        File::put('Modules/' . $argument . '/Providers/' . $argument . 'ServiceProvider.php', $pathServiceProvider);

        // Repositories
        File::makeDirectory('Modules/' . $argument . '/Repositories');
        File::put('Modules/' . $argument . '/Repositories/' . $argument . 'Repo.php', $pathRepo);

        // Http
        File::makeDirectory('Modules/' . $argument . '/Http');
        File::makeDirectory('Modules/' . $argument . '/Http/Controllers');

        // Models
        File::makeDirectory('Modules/' . $argument . '/Models');

        // Routes
        File::makeDirectory('Modules/' . $argument . '/Routes');
        File::put('Modules/' . $argument . '/Routes/' . strtolower($argument) . '_routes.php', $route);

        // Services
        File::makeDirectory('Modules/' . $argument . '/Services');
        File::put('Modules/' . $argument . '/Services/' . $argument . 'Service.php', $service);

        // Admin
        File::makeDirectory('Modules/' . $argument . '/Resources');
        File::makeDirectory('Modules/' . $argument . '/Resources/Views');

        $this->info("Your Module {$argument} Make Successfully");
    }
}
