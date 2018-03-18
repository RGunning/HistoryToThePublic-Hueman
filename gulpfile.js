'use strict';
 
var gulp = require('gulp'),
  sass = require('gulp-sass'),
  autoprefixer = require('gulp-autoprefixer'),
  cleanCSS = require('gulp-clean-css'),
  gulpStylelint = require('gulp-stylelint');

gulp.task('stylelint', function () {
  return gulp
    .src(['scss/*.scss'])
    .pipe(gulpStylelint({
      fix: true,
      failAfterError: false,
      reportOutputDir: 'reports/lint',
      reporters: [
        { formatter: 'verbose', console: true }
      ],
      debug: false
    }))
    .pipe(gulp.dest('scss/'));
});

gulp.task('sass', ['stylelint'], function () {
  return gulp.src('scss/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({ cascade: false })) // moved broswerlists to package.json
    .pipe(cleanCSS({ processImport: false }))
    .pipe(gulp.dest('./'));
});
 
gulp.task('sass:watch', function () {
  gulp.watch('scss/*.scss', ['sass']);
});


