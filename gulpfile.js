const gulp = require('gulp');
const babel = require('gulp-babel');

gulp.task('scripts', function() {
    return gulp.src('src/app.js')
        .pipe(babel({
            presets: ['@babel/preset-env']
        }))
        .pipe(gulp.dest('assets/js'))
});

//TODO set up tasks for browserSync, sass, vendor styles/scripts

gulp.task('default', ['scripts'], function() {
    gulp.watch(['src/*.js'], ['scripts']);
});