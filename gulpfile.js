var gulp = require("gulp"),
    browserSync = require("browser-sync").create(),
    autoprefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    useref = require('gulp-useref'),
    minifyCss = require('gulp-minify-css'),
    gulpIf = require('gulp-if'),
    imagemin = require('gulp-imagemin'),
    del = require('del');

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
    var assets = useref.assets();

    return gulp.src('app/*.html')
        .pipe(assets)

        .pipe(gulpIf('*.css', autoprefixer()))
        .pipe(gulpIf('*.css', minifyCss()))

        .pipe(gulpIf('*.js', uglify()))
        .pipe(assets.restore())
        .pipe(useref())
        .pipe(gulp.dest('dist/'))
});

gulp.task('images', function () {
    return gulp.src('app/img/*.+(png|jpg|jpeg|gif|svg)')
        .pipe(imagemin({
            interlaced: true
        }))
        .pipe(gulp.dest('dist/img/'))
});

gulp.task('clean', function () {
    del('dist');
});

gulp.task('build', ['clean', 'assets', 'images'], function () {
    console.log('Building files');
});

gulp.task('default', ['server', 'watch']);