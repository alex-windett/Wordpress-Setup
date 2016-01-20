module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        imagemin    = require('gulp-imagemin'),
        newer       = require('gulp-newer');

    var gulp        = sourceFile.gulp;

    gulp.task('imagemin', () => {
        return gulp.src(sourceFile.globalConfig.img_src + '/**/*')
            .pipe(newer(sourceFile.globalConfig.img_min))
            .pipe(imagemin({ progressive: true }))
            .pipe(gulp.dest(sourceFile.globalConfig.img_min));
    });
}
