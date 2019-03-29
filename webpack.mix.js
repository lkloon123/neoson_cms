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
    // .js('resources/js/bootstrap.js', 'public/js')
    // .sass('resources/sass/bootstrap.scss', 'public/css')
    .disableNotifications()
    .webpackConfig(webpackConfigurations)
    .copyDirectory('node_modules/tinymce/skins', 'public/css/tinymce/skins')
    .copyDirectory('resources/icons', 'public/images/icon')
    .copyDirectory('resources/img', 'public/images')
    .copy('vendor/alexusmai/laravel-file-manager/resources/assets/css/file-manager.css', 'public/css/file-manager')
    .copy('vendor/alexusmai/laravel-file-manager/resources/assets/js/file-manager.js', 'public/js/file-manager')
    .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/core/bootstrap/js/bootstrap.min.js')
    .copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/core/bootstrap/css/bootstrap.min.css')
    .copy('node_modules/jquery/dist/jquery.min.js', 'public/core/jquery/js/jquery.min.js')
    .copy('node_modules/@fortawesome/fontawesome-free/css/all.min.css', 'public/core/fontawesome/css/fontawesome.min.css')
    .copy('node_modules/@fortawesome/fontawesome-free/js/all.min.js', 'public/core/fontawesome/js/fontawesome.min.js')
    .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/core/fontawesome/webfonts');

if (mix.inProduction()) {
    mix.version();
} else {
    mix.webpackConfig({devtool: "source-map"})
        .sourceMaps();
}
