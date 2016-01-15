var gulp    = require('gulp'),
    sass    = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    watch   = require('gulp-watch');
    gulp = require('gulp');
    imagemin = require('gulp-imagemin');
    pngquant = require('imagemin-pngquant'); // $ npm i -D imagemin-pngquant

var timestamp = new Date().getTime();

var globalConfig = {
    project: 'yesplus',
    assets : 'assets',

    base: '/wp-content/themes/yesplus',

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
};

gulp.task('default', function(){
    console.log('hello');
});

gulp.task('sass', function(){
    gulp.src(globalConfig.scss)
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(globalConfig.css))
})

gulp.task('sass-watch', function(){
    gulp.watch(globalConfig.scss, ['sass'])
})

gulp.task('imagemin', () => {
    return gulp.src(globalConfig.img_src)
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest(globalConfig.img_min));
});

gulp.task('watch', [
    'sass',
    'sass-watch',
    'imagemin'
]);
