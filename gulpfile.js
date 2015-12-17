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
replace = require('gulp-replace');
//wiredep = require('wiredep').stream;

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
    //gulp.watch('bower.json', ['bower']);
});

gulp.task('assets', function () {
    return gulp.src('app/*.html')
        .pipe(useref())

        .pipe(gulpIf('*.css', autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        })))
        .pipe(gulpIf('*.css', minifyCss({compatibility: 'ie8'})))

        .pipe(gulpIf('*.js', uglify()))
        .pipe(gulp.dest('dist/'))
});

gulp.task('images', function () {
    return gulp.src('app/img/**/*.+(png|jpg|jpeg|gif|svg)')
        .pipe(imagemin({
            progressive: true,
            interlaced: true
        }))
        .pipe(gulp.dest('dist/app/img/'))
});

gulp.task('fonts', function () {
    return gulp.src('app/fonts/**/*.+(eot|svg|ttf|woff|woff2)')
        .pipe(gulp.dest('dist/app/fonts'))
});

gulp.task('modernizr', function () {
    return gulp.src('app/js/modernizr.js')
        .pipe(modernizr())
        .pipe(uglify())
        .pipe(gulp.dest('dist/app/js'));
});

gulp.task('favicon', function () {
    return gulp.src('app/*.+(ico|png)')
        .pipe(gulp.dest('dist/app/'));
});

//gulp.task('bower', function () {
//    return gulp.src('app/*.html')
//        .pipe(wiredep())
//        .pipe(gulp.dest('app/'));
//});

gulp.task('clean', function (cb) {
    rimraf('dist', cb);
});

gulp.task('viewsAssets', function () {
    return gulp.src('views/**/*.phtml')
        .pipe(replace('build:css css', 'build:css ../app/css'))
        .pipe(replace('build:js js', 'build:js ../app/js'))
        .pipe(replace('href="/bower', 'href="../app/bower'))
        .pipe(replace('href="/css', 'href="../app/css'))
        .pipe(replace('src="/bower', 'src="../app/bower'))
        .pipe(replace('src="/js', 'src="../app/js'))
        .pipe(useref())

        .pipe(gulpIf('*.css', autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        })))
        .pipe(gulpIf('*.css', minifyCss({compatibility: 'ie8'})))

        .pipe(gulpIf('*.js', uglify()))
        .pipe(gulp.dest('dist/views/'));
});

gulp.task('src', function () {
    return gulp.src('src/**/*.php')
        .pipe(gulp.dest('dist/src/'));
});

gulp.task('composer', function () {
    return gulp.src('composer.json')
        .pipe(gulp.dest('dist/'));
});

gulp.task('dump', function () {
    return gulp.src('dump.sql')
        .pipe(gulp.dest('dist/'));
});

gulp.task('config', function () {
    return gulp.src('config/*.ini.sample')
        .pipe(gulp.dest('dist/config/'));
});

gulp.task('views', function () {
    return gulp.src('views/**/*.phtml')
        .pipe(replace('build:css css', 'build:css /css'))
        .pipe(replace('build:js js', 'build:js /js'))
        .pipe(replace('href="/bower', 'href="../app/bower'))
        .pipe(replace('href="/css', 'href="../app/css'))
        .pipe(replace('src="/bower', 'src="../app/bower'))
        .pipe(replace('src="/js', 'src="../app/js'))
        .pipe(useref())
        .pipe(gulp.dest('dist/views/'));
});


gulp.task('deleteFakeJs', ['views'], function (cb) {
    rimraf('dist/views/js', cb);
});

gulp.task('deleteFakeAssets', ['deleteFakeJs'], function (cb) {
    rimraf('dist/views/css', cb);
});

gulp.task('index', function () {
    return gulp.src('app/index.php')
        .pipe(gulp.dest('dist/app/'));
});

gulp.task('dist', ['viewsAssets', 'images', 'fonts', 'modernizr', 'favicon', 'src', 'composer', 'config', 'deleteFakeAssets', 'index', 'dump']);

gulp.task('build', ['clean'], function () {
    console.log('Building files');
    gulp.start('dist');
});

gulp.task('default', ['server', 'watch']);