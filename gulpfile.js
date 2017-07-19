var gulp = require('gulp')
  , livereload = require('gulp-livereload');

gulp.task('default', function () {
  livereload.listen();

  require('./gulp/app')();
  require('./gulp/admin')();
  require('./gulp/svg-sprite')();
});