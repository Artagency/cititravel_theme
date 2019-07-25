require('es6-promise').polyfill();

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    minifyCSS = require('gulp-minify-css'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    browserify = require('browserify'),
    watchify = require('watchify'),
    source = require('vinyl-source-stream'),
    buffer = require('vinyl-buffer'),
    gutil = require('gutil'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync'),
    babelify  = require('babelify'),
    reload  = browserSync.reload;

gulp.task('sass', function() {

    gulp.src('./src/sass/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['> 1% in PL', 'IE >= 9', 'last 2 version']
        }))
        .pipe(minifyCSS({
            advanced: false
        }))
        .pipe(gulp.dest('.'))
        .pipe(reload({
            stream: true
        }));
});

var homejs_bundle = watchify(
    browserify({
        entries: ['./js/app-homejs.js'],
        cache: {},
        packageCache: {},
        debug: true
    })
    .transform(babelify.configure({
        compact: true,
        presets: ['es2015']
    })))
    .on('update', initHomejs)
    .on('log', gutil.log);

function initHomejs() {
    return homejs_bundle.bundle()
        .on('error', function (err) {
            console.log(err.toString());
            this.emit('end');
        })
        .pipe(source('app-homejs.js'))
        .pipe(buffer())
        .pipe(sourcemaps.init({
           loadMaps: true
        }))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./dist/js'))
        .on('end', function() {
           console.log('ended homejs.js');
        });
}

var bundler = watchify(
    browserify({
        entries: ['./js/app.js'],
        cache: {},
        packageCache: {},
        debug: true
    })
    .transform(babelify.configure({
        compact: true,
        presets: ['es2015']
    })))
    .on('update', initBrowserify)
    .on('log', gutil.log);

function initBrowserify() {
    return bundler.bundle()
        .on('error', function (err) {
            console.log(err.toString());
            this.emit('end');
        })
        .pipe(source('app.js'))
        .pipe(buffer())
        .pipe(sourcemaps.init({
           loadMaps: true
        }))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./dist/js'))
        .on('end', function() {
           console.log('ended bundled.js');
        });
}
gulp.task('initBundle', initBrowserify);
gulp.task('initHomejsBundle', initHomejs);

gulp.task('watch', ['sass', 'initBundle', 'initHomejsBundle'], function() {

    browserSync.init({
        proxy: {
            target: "localhost/wp/cititravel"
        }
    });

    gulp.watch('src/sass/**/*.scss', ['sass']);
    gulp.watch('src/css/**/*.css', ['sass']);

});

gulp.task('default', ['watch']);