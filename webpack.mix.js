const mix = require('laravel-mix');

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
        'jquery', 'vue', 'axios', 'lodash', 'adminbsb-materialdesign', 'vee-validate'
    ])
    .autoload({
        'jquery': ['jQuery', 'jquery', '$']
    })
    .sass('resources/sass/app.scss', 'public/css')
    // .js('resources/js/bootstrap.js', 'public/js')
    // .sass('resources/sass/bootstrap.scss', 'public/css')
    .webpackConfig({
        output: {
            chunkFilename: 'js/chunks/[name].[chunkhash].js',
        },
    })
    .disableNotifications();

if (mix.inProduction()) {
    mix.version();
} else {
    mix.webpackConfig({devtool: "source-map"})
        .sourceMaps();
}