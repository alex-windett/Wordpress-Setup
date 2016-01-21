'use strict';

var gulp            = require('gulp'),
    plugins         = require('gulp-load-plugins')();

var timestamp       = new Date().getTime();

var globalConfig = new function() {
    this.project         = 'theme_name',
    this.assets          = 'assets',

    this.base            = '/wp-content/themes/' + this.project ,

    this.js              = this.assets + '/js',
    this.css             = this.assets + '/css',
    this.scss            = this.assets + '/scss',
    this.scss_includes   = this.scss + ' /includes',
    this.bower           = this.assets + '/bower_components',
    this.img             = this.assets + '/img',

    this.img_src         = this.img + '/src',
    this.img_min         = this.img + '/min/src',
    this.img_sprites     = this.img + '/sprites',

    this.js_min          = this.js + '/min',
    this.js_concat       = this.js + '/concat',
    this.js_custom       = this.js + '/theme_name',
    this.js_vendor       = this.js + '/vendor',

    this.timestamp       = timestamp
};

exports.globalConfig    = globalConfig;
exports.gulp            = gulp;


// * Loop over files in the './gulp-tasks/' directory
var taskPath        = './gulp-tasks/',
    taskList        = require('fs').readdirSync(taskPath);

taskList.forEach(function (taskFile) {
    require(taskPath + taskFile)(gulp, plugins);
});

// * Gulp Tasks
gulp.task('serve', () => {
    var express = require('express');
    var app     = express();
    app.use(express.static(__dirname + '/app'));
    app.listen(4000, function(){
        done();
    });
});

gulp.task('sprites', [
    // * Created task to laod both spritesmith tasks
    'spritesmith:deco',
    'spritesmith:icn'
]);

gulp.task('common', [
    'sprites',
    'js:concat',
    'js:uglify',
    'sass'
]);

gulp.task('dev', [
    'common',
    'watch'
]);

gulp.task('default', [
    'imagemin', // * includes the "newer" task already
    'common'
]);
