module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        clean       = require('gulp-clean');

    var gulp        = sourceFile.gulp;

    gulp.task('clean', () => {
        return gulp.src([
            // * The paths to be clenaed
            sourceFile.globalConfig.css + '/**/*.css',
            sourceFile.globalConfig.js_concat + '/**/*.js',
            sourceFile.globalConfig.js_min + '/**/*.js',
            sourceFile.globalConfig.img_min + '/**/*',
            sourceFile.globalConfig.img_sprites + '/sprites-*.png'
        ], {
            // * Fales - Don't read the rest of the Gulp file
            read: false
        })
        .pipe(clean());
    });
}
