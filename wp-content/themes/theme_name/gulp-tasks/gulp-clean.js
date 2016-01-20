module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        clean       = require('gulp-clean');

    var gulp        = sourceFile.gulp;

    gulp.task('clean', () => {
        return gulp.src([
            sourceFile.globalConfig.css + '/**/*.css',
            sourceFile.globalConfig.js_concat + '/**/*.js',
            sourceFile.globalConfig.js_min + '/**/*.js',
            sourceFile.globalConfig.img_min + '/**/*',
            sourceFile.globalConfig.img_sprites + '/sprites-*.png'
        ], { read: false })
        .pipe(clean());
    });
}
