<?php

namespace App\Providers;

use App\Libs\Cart\Cart;
use App\Libs\Category;
use App\Libs\Comparison;
use App\Libs\DeliveryTime\ProductSourceHandler;
use App\Libs\Enums\Shipping;
use App\Libs\Lang;
use App\Libs\User;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use Spatie\Flash\Flash;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Relation::morphMap($this->generateMorphMap());

        $this->app->singleton('Lang', function () {
            return new Lang();
        });

        $this->app->singleton('Cart', function () {
            return new Cart();
        });

        $this->app->singleton('User', function () {
            return new User();
        });

        $this->app->singleton('Category', function () {
            return new Category();
        });

        $this->app->singleton('Comparison', function () {
            return new Comparison();
        });

        $this->app->singleton('ProductSourceHandler', function () {
            return new ProductSourceHandler(new Shipping(Shipping::WHOLE));
        });

        Flash::levels([
            'success' => 'alert-success',
            'warning' => 'alert-warning',
            'error' => 'alert-danger',
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        \URL::forceScheme('https');
        if (env('APP_DEBUG_QUERY')) {
            DB::listen(function ($query) {
                File::append(
                    storage_path('/logs/query.log'),
                    $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
                );
            });
        }

        Paginator::useBootstrap();
    }

    private function generateMorphMap(): array
    {
        $models = File::allFiles(app_path() . '/Models');

        $classPaths = [];

        foreach ($models as $model) {
            $classPaths[] = str_replace(
                [app_path(), '/', '.php'],
                ['App', '/', ''],
                $model->getRealPath()
            );
        }

        foreach ($classPaths as $key => $classPath) {
            $classPath = str_replace('/', '\\', $classPath);

            try {
                $modelIsAbstract = (new ReflectionClass($classPath))->isAbstract();
            } catch (\ReflectionException $e) {
                Log::error($e->getMessage());

                continue;
            }

            if (! $modelIsAbstract) {
                $classPaths[(new $classPath())->getTable()] = $classPath;
            }

            unset($classPaths[$key]);
        }

        $classPaths['sale_translations'] = Sale::class;
        unset($classPaths['sales']);

        return $classPaths;
    }
}
