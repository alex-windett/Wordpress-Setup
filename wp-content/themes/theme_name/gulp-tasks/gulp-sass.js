module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        sass        = require('gulp-sass'),
        sourcemaps  = require('gulp-sourcemaps'),
        livereload  = require('gulp-livereload');

    var gulp        = sourceFile.gulp;

    gulp.task('sass', () => {
        gulp.src([
            // * Files to be compiled
            sourceFile.globalConfig.scss + '/app.scss',
            sourceFile.globalConfig.scss + '/admin.scss'
        ])
        .pipe(sourcemaps.init()) // * Initiate sourcemaps
        .on('error', function(err){
           displayError(err); // ** Show any errors and continue compiling
        })
        .pipe(sass({
            // * Options for compiled CSS
            outputStyle: 'compressed',
            sourceComments: 'map',
            includePaths: [
                // * Include anything created in bower components
                sourceFile.globalConfig.bower + '/foundation/scss/',
                sourceFile.globalConfig.bower + '/owl-carousel2/src/scss'
            ]
        }))
        .pipe(sourcemaps.write()) // * Write the sourcemaps
        // .pipe(sourcemaps.write('./maps')) ** Declare path of map file if neeeded
        .pipe(gulp.dest(sourceFile.globalConfig.css)) // * Destination of CSS file
        .pipe(livereload()); // * Initiate livereload
    });
}
