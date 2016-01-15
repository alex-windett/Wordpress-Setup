var gulp    = require('gulp'),
    plugins = require('gulp-load-plugins')(),

    sass        = require('gulp-sass'),
    sourcemaps  = require('gulp-sourcemaps'),
    watch       = require('gulp-watch'),

    imagemin = require('gulp-imagemin'),
    pngquant = require('imagemin-pngquant'), // $ npm i -D imagemin-pngquant

    timestamp = new Date().getTime();

module.exports = {

        var globalConfig: function() {
            project: 'yesplus',
            assets : 'assets',

            base: '/wp-content/themes/yesplus',

            gulp_tasks   : '<%= globalConfig.base %>/grunt-tasks',

            js           : '<%= globalConfig.assets %>/js',
            css          : '<%= globalConfig.assets %>/css',
            scss         : '<%= globalConfig.assets %>/scss',
            scss_includes: '<%= globalConfig.scss %>/includes',
            bower        : '<%= globalConfig.assets %>/bower_components',
            img          : '<%= globalConfig.assets %>/img',

            img_src    : '<%= globalConfig.img %>/src',
            img_min    : '<%= globalConfig.img %>/min/src',
            img_sprites: '<%= globalConfig.img %>/sprites',

            js_min   : '<%= globalConfig.js %>/min',
            js_concat: '<%= globalConfig.js %>/concat',
            js_custom: '<%= globalConfig.js %>/<%= globalConfig.project %>',

            timestamp: timestamp
        }
}

gulp.task('sass', require('./gulp-tasks/gulp-sass.js')(gulp, plugins));
gulp.task('sass-watch', require('./gulp-tasks/gulp-sass-watch.js')(gulp, plugins));
gulp.task('imagemin', require('./gulp-tasks/gulp-imagemin.js')(gulp, plugins));

gulp.task('default', [
    'sass',
    'sass-watch',
    'imagemin'
]);
