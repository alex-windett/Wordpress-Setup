module.exports = function(gulp, $) {
    'use strict';

    var sourceFile  = require('../gulpfile.js'),
        spritesmith = require('gulp.spritesmith'),
        livereload  = require('gulp-livereload');

    var gulp        = sourceFile.gulp;

    // * Sprite task for decoration spritesheet
    gulp.task('spritesmith:deco', () => {
        var spriteData = gulp.src(sourceFile.globalConfig.img_sprites + '/deco/**/*') // * Location of images
            .pipe(spritesmith({
                imgName: 'sprites-deco.png', // * Name of sprite sheet
                cssName: '_sprites-deco.scss' // * Name of sprite style sheet
            }));
        spriteData.img.pipe(gulp.dest(sourceFile.globalConfig.img_sprites)); // * Location of sprite sheet
        spriteData.css.pipe(gulp.dest(sourceFile.globalConfig.scss + '/includes')) // * Location of sprite style sheet
        .pipe(livereload()); // * Initiate livereload
    });

    // * Sprite task for icon spritesheet
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
