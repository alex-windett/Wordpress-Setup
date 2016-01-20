module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        sourcemaps  = require('gulp-sourcemaps'),
        newer       = require('gulp-newer'),
        concat      = require('gulp-concat'),
        livereload  = require('gulp-livereload');

    var gulp        = sourceFile.gulp;

    gulp.task('js:concat', () => {
        return gulp.src([
            sourceFile.globalConfig.js_custom + '/jquery-start.js',
            sourceFile.globalConfig.js_custom + '/jquery-end.js',
            sourceFile.globalConfig.js_custom + '/functions/*.js',
            sourceFile.globalConfig.js_custom + '/doc-ready.js',
            sourceFile.globalConfig.vendor + '/*.js'
        ])
        .pipe(sourcemaps.init())
        .pipe(newer(sourceFile.globalConfig.js_concat + '/app.js'))
        .pipe(concat('app.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(sourceFile.globalConfig.js_concat))
        .pipe(livereload());
    });
}
