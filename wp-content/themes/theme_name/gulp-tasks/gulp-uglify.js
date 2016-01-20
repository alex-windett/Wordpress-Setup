module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        rename      = require('gulp-rename'),
        gutil       = require('gulp-util'),
        uglify      = require('gulp-uglify');

    var gulp        = sourceFile.gulp;

    gulp.task('js:uglify', () => {
        return gulp.src(sourceFile.globalConfig.js_concat + '/*.js')
        .pipe(uglify().on('error', gutil.log))
        .pipe(rename({
            extname: '.min.js'
        }))
        .pipe(gulp.dest(sourceFile.globalConfig.js_min));
    });
}
