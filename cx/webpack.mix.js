const mix = require('laravel-mix');
const jsPath = 'resources/js';
const nodeModulesPath = 'node_modules';

mix.scripts([
    `${jsPath}/jquery.js`,
], 'public/js/jquery.js')

mix.scripts([
    `${jsPath}/google-tag.js`,
    `${nodeModulesPath}/select2/dist/js/select2.full.js`,
    `${nodeModulesPath}/select2/dist/js/i18n/hu.js`,
    `${jsPath}/toastr.js`,
    `${jsPath}/ion.rangeSlider.js`,
    `${jsPath}/RangeFilter.js`,
    `${jsPath}/helper.js`,
    `${jsPath}/nav.js`,
    `${jsPath}/filter.js`,
    `${jsPath}/base.js`,
    `${jsPath}/q-search.js`,
    `${jsPath}/product.js`,
    `${jsPath}/order.js`,
    `${jsPath}/modal.js`,
], 'public/js/scripts.js')

    .sass('resources/sass/app.scss', 'public/css/app.css')
    .sass('resources/sass/accordion.scss', 'public/css/accordion.css')
    .sass('resources/sass/order.scss', 'public/css/order.css')
    .sass('resources/sass/warranty.scss', 'public/css/warranty.css')
    .sass('resources/sass/datatable.scss', 'public/css/datatable.css')
    .sass('resources/sass/comparison.scss', 'public/css/comparison.css')

    .js('resources/js/app.js', 'public/js')
    .js(`${jsPath}/customer-premise.js`, 'public/js')
    .js(`${jsPath}/shipping.js`, 'public/js')
    .js(`${jsPath}/lightbox.js`, 'public/js')
    .js(`${jsPath}/comparison.js`, 'public/js')
    .js(`${jsPath}/knowledge.js`, 'public/js')

    .postCss('resources/css/tailwind.css', 'public/css/tailwind.css', [
        require('tailwindcss'),
    ])

    .vue()

    .copy('resources/images', 'public/assets/images')
    .copy('resources/assets', 'public/assets');

if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps(false, 'eval-source-map');
}

mix.browserSync({
    proxy: 'riel.test',
});
