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
        'jquery', 'vue', 'vue-router', 'vuex', 'axios', 'lodash', 'vee-validate', 'popper.js', 'tooltip.js', 'bootstrap', 'jquery.nicescroll', 'moment', '@fortawesome/fontawesome-free',
        'bootstrap-daterangepicker', 'izitoast'
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
