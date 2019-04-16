const mix = require('laravel-mix');
const webpackConfigurations = require('./webpack.config');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/js/app.js', 'public/js')
    .extract([
        '@fortawesome/fontawesome-free',
        'axios',
        'bootstrap',
        'bootstrap-daterangepicker',
        'epic-spinners',
        'izitoast',
        'jquery',
        'jquery.nicescroll',
        'lodash',
        'moment',
        'popper.js',
        'slug',
        'tooltip.js',
        'vee-validate',
        'vue',
        'vue-content-loading',
        'vue-good-table',
        'vue-js-toggle-button',
        'vue-multiselect',
        'vue-router',
        'vue2-transitions',
        'vuex',
    ])
    .autoload({
        'jquery': ['jQuery', 'jquery', '$']
    })
    .sass('resources/sass/app.scss', 'public/css')
    .disableNotifications()
    .webpackConfig(webpackConfigurations)
    .copyDirectory('node_modules/tinymce/skins', 'public/css/tinymce/skins')
    .copyDirectory('resources/icons', 'public/images/icon')
    .copyDirectory('resources/img', 'public/images')
    .copy('vendor/alexusmai/laravel-file-manager/resources/assets/css/file-manager.css', 'public/css/file-manager')
    .copy('vendor/alexusmai/laravel-file-manager/resources/assets/js/file-manager.js', 'public/js/file-manager');

if (mix.inProduction()) {
    mix.version();
} else {
    mix.webpackConfig({devtool: "source-map"})
        .sourceMaps();
}
