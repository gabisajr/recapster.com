let gulp = require('gulp')
  , sass = require('gulp-sass')
  , cleanCSS = require('gulp-clean-css')
  , concat = require('gulp-concat')
  , livereload = require('gulp-livereload')
  , autoprefixer = require('gulp-autoprefixer');

gulp.task('app-styles', function () {
  return gulp.src([
    'resources/assets/sass/bootstrap-4/bootstrap.scss',
    'public/lib/select2/css/select2.min.css',
    'public/lib/jquery-ui-1.12.1/jquery-ui.min.css',
    'public/lib/fancyBox-3.0/jquery.fancybox.min.css',
    'resources/assets/sass/font-awesome-4.7.0/font-awesome.scss',
    'resources/assets/sass/app.scss'
  ])
    .pipe(sass()['on']('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(concat('app.min.css'))
    .pipe(cleanCSS({level: {1: {specialComments: 0}}}))
    .pipe(gulp.dest('public/css'))
    .pipe(livereload())
    ;
});

module.exports = function () {
  gulp.watch('resources/assets/sass/**/*.scss', ['app-styles']);
  gulp.watch('resources/views/**/*.blade.php', function () {
    livereload.reload();
  });

  // force run
  gulp.run(['app-styles']);
};