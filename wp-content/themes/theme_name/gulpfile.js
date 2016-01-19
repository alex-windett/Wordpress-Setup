var gulp            = require('gulp'),
    sass            = require('gulp-sass'),
    sourcemaps      = require('gulp-sourcemaps');

var timestamp = new Date().getTime();

var globalConfig = {
    project         : 'theme_name',
    assets          : 'assets',

    base            : '/wp-content/themes/theme_name',

    js              : './assets/js',
    css             : './assets/css',
    scss            : './assets/scss',
    scss_includes   : './assets/scss/includes',
    bower           : './assets/bower_components',
    img             : './assets/img',

    img_src         : './assets/img/src',
    img_min         : './assets/img/min/src',
    img_sprites     : './assets/img/sprites',

    js_min          : './assets/js/min',
    js_concat       : './assets/js/concat',
    js_custom       : './assets/js/theme_name',

    timestamp       : timestamp
};

gulp.task('default', () => {
    console.log(globalConfig.scss);
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
        globalConfig.scss + '/**/*.scss'
    ], ['sass'])
    .on('change', function(event) {
        console.log('File' + event.path + ' was ' + event.type + ', running tasks...' );
    });
});


gulp.task('dev', [
    'sass',
    'watch'
]);
