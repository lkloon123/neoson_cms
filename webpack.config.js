const webpack = require('webpack');

module.exports = {
    output: {
        chunkFilename: 'js/chunks/[name].[chunkhash].js',
    },
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '@node_modules': __dirname + '/node_modules',
            '@components': __dirname + '/resources/js/components',
            '@pages': __dirname + '/resources/js/pages',
            '@css': __dirname + '/resources/sass',
            '@stisla': __dirname + '/resources/js/stisla'
        },
        symlinks: false
    }
};
