var gulp            = require('gulp'),
    sass            = require('gulp-sass'),
    sourcemaps      = require('gulp-sourcemaps');
    source          = require ('../gulpfile.js');

gulp.task('sass', () => {
    gulp.src([
        source.globalConfig.scss + '/app.scss',
        source.globalConfig.scss + '/admin.scss'
    ])
    .pipe(sourcemaps.init())
    .on('error', function(err){
       displayError(err); // ** Show any errors and continue compiling
    })
    .pipe(sass({
        outputStyle: 'compressed',
        sourceComments: 'map',
        includePaths: [
            source.globalConfig.bower + '/foundation/scss/',
            source.globalConfig.bower + '/owl-carousel2/src/scss'
        ]
    }))
    .pipe(sourcemaps.write())
    // .pipe(sourcemaps.write('./maps')) ** Declare path of map file if neeeded
    .pipe(gulp.dest(source.globalConfig.css));
})
