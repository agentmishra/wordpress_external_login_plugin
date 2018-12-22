'use strict';

var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var sass = require('gulp-sass');

// URL used for serving content
var serveUrl = "http://dojo2017/wp-admin/options-general.php?page=external-login";

sass.compiler = require('node-sass');

gulp.task('sass', function () {
  return gulp.src('./styles/style.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./styles'))
    .pipe(browserSync.stream());
});

gulp.task('serve', ['sass'], function() {
  browserSync.init({
    proxy: serveUrl
  });

  gulp.watch('./styles/**/*.scss', ['sass']);
  gulp.watch("app/*.php").on('change', browserSync.reload);
});

gulp.task('watch', function () {
  gulp.watch('./styles/**/*.scss', ['sass']);
});

gulp.task('default', ['sass', 'serve']);