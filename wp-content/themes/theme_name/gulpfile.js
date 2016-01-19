var gulp            = require('gulp'),
    sass            = require('gulp-sass'),
    sourcemaps      = require('gulp-sourcemaps');

var timestamp = new Date().getTime();

var globalConfig = {
    project: 'theme_name',
    assets : 'assets',

    base: '/wp-content/themes/theme_name',

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

gulp.task('default', () => {
    console.log('hello');
});

gulp.task('sass', function() {
    gulp.src([
        './assets/scss/app.scss'
    ])
    .pipe(sourcemaps.init())
    .on('error', function(err){
       displayError(err); // ** Show any errors and continue compiling
    })
    .pipe(sass({
        outputStyle: 'compressed',
        sourceComments: 'map',
        includePaths: [
            './assets/bower_components/foundation/scss/',
            './assets/bower_components/owl-carousel2/src/scss'
        ]
    }))
    .pipe(sourcemaps.write())
    // .pipe(sourcemaps.write('./maps')) ** Declare path of map file if neeeded
    .pipe(gulp.dest('./assets/css'));
})

// gulp.task('sass-watch', () => {
//     gulp.watch('./assets/scss/**/*.scss', ['sass'])
// })
//
// gulp.task('imagemin', () => {
//     return gulp.src(globalConfig.img_src)
//         .pipe(imagemin({
//             progressive: true,
//             svgoPlugins: [{removeViewBox: false}],
//             use: [pngquant()]
//         }))
//         .pipe(gulp.dest(globalConfig.img_min));
// });

// gulp.task('watch', [
//     'sass',
//     'sass-watch',
//     'imagemin'
// ]);
