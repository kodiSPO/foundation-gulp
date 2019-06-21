'use strict';

var gulp          = require('gulp');
var sass          = require('gulp-sass');
sass.compiler     = require('node-sass');
var concat        = require('gulp-concat');
var cssnano       = require('gulp-cssnano');
var minify        = require('gulp-minify');
var autoprefixer  = require('gulp-autoprefixer');
var fs            = require('fs');
var GulpSSH       = require('gulp-ssh');
var GulpSSHconfig = require('./gulpSSHconfig');


/*
** default task
*/
gulp.task('default', function() {
    gulp.watch('./css/scss/**/*.scss', gulp.series(
        'css', 
        'ssh-write-css'
    ));
    gulp.watch(['./js/assets/**/*.js', '!./js/assets/theme.js'], gulp.series(
        'js:concat', 
        'js:minify',
        'ssh-write-js'
    ));
});


/*
** convert scss to css, concatenate and minify
*/
gulp.task('css', function () {
  return gulp.src(['./css/scss/plugins/**/*.{css,scss}', './css/scss/*.scss'])
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(concat('theme.min.css'))
    .pipe(autoprefixer({
            overrideBrowserslist: ['last 2 versions'],
            cascade: false
        }))
    .pipe(cssnano())
    .pipe(gulp.dest('./css'));
});


/*
** concatenate js
*/
gulp.task('js:concat', function () {
  return gulp.src(['./js/assets/plugins/*.js', './js/assets/*.js', './js/assets/parts/*.js', '!./js/assets/theme.js'])
    .pipe(concat('theme.js'))
    .pipe(gulp.dest('./js/assets'));
});


/*
** minify js
*/
gulp.task('js:minify', function () {
  return gulp.src(['./js/assets/theme.js'])
    .pipe(minify({
        ext: {
            min: '.min.js'
        },
        noSource: true
    }))
    .pipe(gulp.dest('./js'));
});


/*
** upload on remote server
*/
var gulpSSH = new GulpSSH({
    ignoreErrors: false,
    sshConfig: GulpSSHconfig.config
});

gulp.task('ssh-write-css', function () {
    return gulp.src('./css/theme.min.css')
        .pipe(gulpSSH.dest(GulpSSHconfig.cssPath));
})

gulp.task('ssh-write-js', function () {
    return gulp.src('./js/theme.min.js')
        .pipe(gulpSSH.dest(GulpSSHconfig.jsPath));
})




