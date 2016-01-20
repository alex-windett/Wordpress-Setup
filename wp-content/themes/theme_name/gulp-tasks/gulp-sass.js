module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        sass        = require('gulp-sass'),
        sourcemaps  = require('gulp-sourcemaps'),
        livereload  = require('gulp-livereload');

    var gulp        = sourceFile.gulp;

    gulp.task('sass', () => {
        gulp.src([
            sourceFile.globalConfig.scss + '/app.scss',
            sourceFile.globalConfig.scss + '/admin.scss'
        ])
        .pipe(sourcemaps.init())
        .on('error', function(err){
           displayError(err); // ** Show any errors and continue compiling
        })
        .pipe(sass({
            outputStyle: 'compressed',
            sourceComments: 'map',
            includePaths: [
                sourceFile.globalConfig.bower + '/foundation/scss/',
                sourceFile.globalConfig.bower + '/owl-carousel2/src/scss'
            ]
        }))
        .pipe(sourcemaps.write())
        // .pipe(sourcemaps.write('./maps')) ** Declare path of map file if neeeded
        .pipe(gulp.dest(sourceFile.globalConfig.css))
        .pipe(livereload());
    });
}
