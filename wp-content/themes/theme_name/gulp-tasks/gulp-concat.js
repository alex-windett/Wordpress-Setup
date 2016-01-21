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
            // * Make sure the files are ordered correctly
            // * jQuery start needs to come before jQuery end
            // * the 'functions' folder should come before 'doc-ready.js'
            sourceFile.globalConfig.js_custom + '/jquery-start.js',
            sourceFile.globalConfig.js_custom + '/jquery-end.js',
            sourceFile.globalConfig.js_custom + '/functions/*.js',
            sourceFile.globalConfig.js_custom + '/doc-ready.js',
            sourceFile.globalConfig.vendor + '/*.js'
        ])
        .pipe(sourcemaps.init()) // * initiate a sourcemap
        .pipe(newer(sourceFile.globalConfig.js_concat + '/app.js')) // * Only concatinating changed files
        .pipe(concat('app.js')) // * Concatinated file name
        .pipe(sourcemaps.write()) // * Write the sourcemap
        .pipe(gulp.dest(sourceFile.globalConfig.js_concat)) // * Destination of the concatinated file
        .pipe(livereload()); // * Once completed live reload the page
    });
}
