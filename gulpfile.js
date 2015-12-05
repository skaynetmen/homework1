var gulp = require("gulp"),
    browserSync = require("browser-sync").create(),
    autoprefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    useref = require('gulp-useref'),
    minifyCss = require('gulp-minify-css'),
    gulpIf = require('gulp-if'),
    imagemin = require('gulp-imagemin'),
    rimraf = require('rimraf'),
    modernizr = require('gulp-modernizr');

gulp.task('server', function () {
    browserSync.init({
        port: 9000,
        server: {
            baseDir: 'app'
        }
    });
});

gulp.task('watch', function () {
    gulp.watch([
        'app/*.html',
        'app/js/*.js',
        'app/css/*.css'
    ]).on('change', browserSync.reload);
});

gulp.task('assets', function () {
    return gulp.src('app/*.html')
        .pipe(useref())

        .pipe(gulpIf('*.css', autoprefixer()))
        .pipe(gulpIf('*.css', minifyCss()))

        .pipe(gulpIf('*.js', uglify()))
        .pipe(gulp.dest('dist/'))
});

gulp.task('images', function () {
    return gulp.src('app/img/**/*.+(png|jpg|jpeg|gif|svg)')
        .pipe(imagemin({
            interlaced: true
        }))
        .pipe(gulp.dest('dist/img/'))
});

gulp.task('fonts', function () {
    return gulp.src('app/fonts/**/*.+(eot|svg|ttf|woff|woff2)')
        .pipe(gulp.dest('dist/fonts'))
});

gulp.task('modernizr', function () {
    return gulp.src('app/js/modernizr.js')
        .pipe(modernizr())
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
});

gulp.task('favicon', function () {
    return gulp.src('app/*.+(ico|png)')
        .pipe(gulp.dest('dist/'))
});

gulp.task('clean', function (cb) {
    rimraf('dist', cb);
});

gulp.task('build', ['clean', 'assets', 'images', 'fonts', 'modernizr', 'favicon'], function () {
    console.log('Building files');
});

gulp.task('default', ['server', 'watch']);