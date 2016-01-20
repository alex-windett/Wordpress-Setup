module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        watch       = require('gulp-watch'),
        livereload  = require('gulp-livereload');

    var gulp        = sourceFile.gulp;

    gulp.task('watch', () => {
        livereload.listen();
        gulp.watch([
            sourceFile.globalConfig.scss + '/**/*.scss',
            sourceFile.globalConfig.js + '/**/*.js',
            sourceFile.globalConfig.img_sprites + '/*.png'
            // sourceFile.globalConfig.img_src + '/**/*'
        ], [
            'sass',
            'js:concat',
            // 'sprites',
            // 'imagemin'
        ])
        .on('change', function(event) {
            console.log('File' + event.path + ' was ' + event.type + ', running tasks...' );
        });
    });

}
