module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        imagemin    = require('gulp-imagemin'),
        newer       = require('gulp-newer');

    var gulp        = sourceFile.gulp;

    gulp.task('imagemin', () => {
        return gulp
            .src(sourceFile.globalConfig.img_src + '/**/*') // * The files to be minified
            .pipe(newer(sourceFile.globalConfig.img_min)) // * Do not run task on already minified images
            .pipe(imagemin({
                // * Pass in options
                progressive: true,
                optimizationLevel: 5,
                multipass: true // * Optimise SVGs multiple times untill fully optimised
            }))
            .pipe(gulp.dest(sourceFile.globalConfig.img_min));
    });
}
