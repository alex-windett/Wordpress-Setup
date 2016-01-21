module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        rename      = require('gulp-rename'),
        gutil       = require('gulp-util'),
        uglify      = require('gulp-uglify');

    var gulp        = sourceFile.gulp;

    gulp.task('js:uglify', () => {
        return gulp.src(sourceFile.globalConfig.js_concat + '/*.js') // * Location of concatinated js file
        .pipe(uglify().on('error', gutil.log)) // * Uglify and display any syntax errors
        .pipe(rename({
            // * Pass in any options
            extname: '.min.js' // * Add the '.min' extension to the file
        }))
        .pipe(gulp.dest(sourceFile.globalConfig.js_min)); // * Destination of the uglified file
    });
}
