var gulp            = require('gulp'),
    sass            = require('gulp-sass'),
    sourcemaps      = require('gulp-sourcemaps'),
    concat          = require('gulp-concat'),
    uglify          = require('gulp-uglify'),
    rename          = require('gulp-rename'),
    gutil           = require('gulp-util'),
    clean           = require('gulp-clean'),
    spritesmith     = require('gulp.spritesmith'),
    requireDir      = require('require-dir'),
    imagemin        = require('gulp-imagemin');

var timestamp = new Date().getTime();

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

// requireDir('./gulp-tasks', { recursive: true });

gulp.task('imagemin', () => {
    return gulp.src(globalConfig.img_src + '/**/*')
        .pipe(imagemin({ progressive: true }))
        .pipe(gulp.dest(globalConfig.img_min));
});

gulp.task('sass', () => {
    gulp.src([
        globalConfig.scss + '/app.scss',
        globalConfig.scss + '/admin.scss'
    ])
    .pipe(sourcemaps.init())
    .on('error', function(err){
       displayError(err); // ** Show any errors and continue compiling
    })
    .pipe(sass({
        outputStyle: 'compressed',
        sourceComments: 'map',
        includePaths: [
            globalConfig.bower + '/foundation/scss/',
            globalConfig.bower + '/owl-carousel2/src/scss'
        ]
    }))
    .pipe(sourcemaps.write())
    // .pipe(sourcemaps.write('./maps')) ** Declare path of map file if neeeded
    .pipe(gulp.dest(globalConfig.css));
})


gulp.task('watch', () => {
    gulp.watch([
        globalConfig.scss + '/**/*.scss',
        globalConfig.js + '/**/*.js',
        globalConfig.img_sprites + '/*.png'
    ], [
        'sass',
        'js:concat',
        'spritesmith'
    ])
    .on('change', function(event) {
        console.log('File' + event.path + ' was ' + event.type + ', running tasks...' );
    });
});

gulp.task('js:concat', () => {
    return gulp.src([
        globalConfig.js_custom + '/jquery-start.js',
        globalConfig.js_custom + '/jquery-end.js',
        globalConfig.js_custom + '/functions/*.js',
        globalConfig.js_custom + '/doc-ready.js',
        globalConfig.vendor + '/*.js'
    ])
    .pipe(sourcemaps.init())
    .pipe(concat('app.js'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(globalConfig.js_concat))
});

gulp.task('js:uglify', () => {
    return gulp.src(globalConfig.js_concat + '/*.js')
    .pipe(uglify().on('error', gutil.log))
    .pipe(rename({
        extname: '.min.js'
    }))
    .pipe(gulp.dest(globalConfig.js_min));
});

gulp.task('clean', () => {
    return gulp.src([
        globalConfig.css + '/**/*.css',
        globalConfig.js_concat + '/**/*.js',
        globalConfig.js_min + '/**/*.js',
        globalConfig.img_min + '/**/*',
        globalConfig.img_sprites + '/sprites-*.png'
    ], { read: false })
    .pipe(clean());
});

gulp.task('spritesmith:deco', () => {
    var spriteData = gulp.src(globalConfig.img_sprites + '/deco/**/*')
        .pipe(spritesmith({
            imgName: 'sprites-deco.png',
            cssName: '_sprites-deco.scss'
        }));
    spriteData.img.pipe(gulp.dest(globalConfig.img_sprites));
    spriteData.css.pipe(gulp.dest(globalConfig.scss + '/includes'));
});

gulp.task('spritesmith:icn', () => {
    var spriteData = gulp.src(globalConfig.img_sprites + '/icn/**/*')
        .pipe(spritesmith({
            imgName: 'sprites-icn.png',
            cssName: '_sprites-icn.scss'
        }));
    spriteData.img.pipe(gulp.dest(globalConfig.img_sprites));
    spriteData.css.pipe(gulp.dest(globalConfig.scss + '/includes'));
});

gulp.task('sprites', [
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
    'common'
]);
