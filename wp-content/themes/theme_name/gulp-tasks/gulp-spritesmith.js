module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        spritesmith = require('gulp.spritesmith'),
        livereload  = require('gulp-livereload');

    var gulp        = sourceFile.gulp;

    gulp.task('spritesmith:deco', () => {
        var spriteData = gulp.src(sourceFile.globalConfig.img_sprites + '/deco/**/*')
            .pipe(spritesmith({
                imgName: 'sprites-deco.png',
                cssName: '_sprites-deco.scss'
            }));
        spriteData.img.pipe(gulp.dest(sourceFile.globalConfig.img_sprites));
        spriteData.css.pipe(gulp.dest(sourceFile.globalConfig.scss + '/includes'))
        .pipe(livereload());
    });

    gulp.task('spritesmith:icn', () => {
        var spriteData = gulp.src(sourceFile.globalConfig.img_sprites + '/icn/**/*')
            .pipe(spritesmith({
                imgName: 'sprites-icn.png',
                cssName: '_sprites-icn.scss'
            }));
        spriteData.img.pipe(gulp.dest(sourceFile.globalConfig.img_sprites));
        spriteData.css.pipe(gulp.dest(sourceFile.globalConfig.scss + '/includes'))
        .pipe(livereload());
    });
}
