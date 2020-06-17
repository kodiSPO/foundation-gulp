'use strict';

let gulp          = require('gulp');
let sass          = require('gulp-sass');
sass.compiler     = require('node-sass');
let concat        = require('gulp-concat');
let cssnano       = require('gulp-cssnano');
let minify        = require('gulp-minify');
let autoprefixer  = require('gulp-autoprefixer');


/*
** default task
*/
gulp.task('default', function() {
    gulp.watch(['./blocks/**/*.scss', './css/scss/**/*.scss'], gulp.series(
        'css',
    ));
    gulp.watch(['./blocks/**/*.js', './js/assets/**/*.js', '!./js/assets/theme.js'], gulp.series(
        'js:concat', 
        'js:minify',
    ));
});


/*
** convert scss to css, concatenate and minify
*/
gulp.task('css', function () {
  return gulp.src(
      [
          './css/scss/plugins/**/*.{css,scss}',
          './css/scss/*.scss',
          './blocks/**/*.scss',
      ]
  )
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
  return gulp.src(
      [
          './js/assets/plugins/*.js',
          './js/assets/main.js',
          './js/assets/parts/*.js',
          './blocks/**/*.js'
      ]
  )
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
