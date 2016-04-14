'use strict';

/**
 * Require dependencies
 */
var gulp = require('gulp'),
    cache = require('gulp-cached'),
    beep = require('beepbeep'),
    plumber = require('gulp-plumber'),
    phpcs = require('gulp-phpcs');

/**
 * Setup files to watch
 */
var files = [
  '**/**/*.php',
  '!node_modules/**/*.*',
  '!vendor/**/*.*'
];

/**
 * Error handling
 */
var gulp_src = gulp.src;

gulp.src = function() {
  return gulp_src.apply(gulp, arguments)

  .pipe(plumber(function(error) {
    beep();
  }));
};

/**
 * PHP CodeSniffer
 */
gulp.task('phpcs', function() {
  return gulp.src(files)

  // Use cache to filter out unmodified files
  .pipe(cache('phpcs'))

  // Sniff code
  .pipe(phpcs({
    bin: 'vendor/bin/phpcs',
    standard: 'PSR2',
    warningSeverity: 0
  }))

  // Log errors and fail afterwards
  .pipe(phpcs.reporter('log'))
  .pipe(phpcs.reporter('fail'));
});

/**
 * Watch
 */
gulp.task('default', function() {
  gulp.watch(files, ['phpcs']);
});
