module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        watch       = require('gulp-watch'),
        livereload  = require('gulp-livereload');

    var gulp        = sourceFile.gulp;

    gulp.task('watch', () => {
        livereload.listen();
        // * The files to watch
        gulp.watch([
            sourceFile.globalConfig.scss + '/**/*.scss',
            sourceFile.globalConfig.js + '/**/*.js',
            sourceFile.globalConfig.img_sprites + '/icn/*',
            sourceFile.globalConfig.img_sprites + '/deco/*'
        ], [
            // * The tasks to be run on the above files
            'sass',
            'js:concat',
            'sprites'
        ])
        .on('change', function(event) {
            // * Display which file was changed
            console.log('File' + event.path + ' was ' + event.type + ', running tasks...' );
        });
    });

}
