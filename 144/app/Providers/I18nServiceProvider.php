<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class I18nServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('translations', function () {
            return '<?php echo "<script>window.translations = " . (new \App\Classes\I18n())->getTranslations() ."</script>"; ?>';
        });
    }
}
