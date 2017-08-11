var gulp = require('gulp')
  , sass = require('gulp-sass')
  , cleanCSS = require('gulp-clean-css')
  , concat = require('gulp-concat')
  , livereload = require('gulp-livereload')
  , uglify = require('gulp-uglify')
  , autoprefixer = require('gulp-autoprefixer');

gulp.task('app-styles', function () {
  return gulp.src([
    'resources/assets/sass/bootstrap-4/bootstrap.scss',
    'public/lib/fancyBox-3.0/jquery.fancybox.min.css',
    'resources/assets/sass/font-awesome-4.7.0/font-awesome.scss',
    'resources/assets/sass/app.scss'
  ])
    .pipe(sass()['on']('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(concat('app.min.css'))
    .pipe(cleanCSS())
    .pipe(gulp.dest('public/css'))
    .pipe(livereload())
    ;
});

gulp.task('app-scripts', function () {
  return gulp.src('resources/assets/js/**/*.js')
    .pipe(uglify())
    .on('error', swallowError)
    .pipe(gulp.dest('public/js'))
    .pipe(livereload())
    ;
});

function swallowError(error) {
  console.error(error.toString());
  this.emit('end');
}

module.exports = function () {
  gulp.watch('resources/assets/sass/**/*.scss', ['app-styles']);
  gulp.watch('resources/assets/js/**/*.js', ['app-scripts']);
  gulp.watch('resources/views/**/*.blade.php', function () {
    livereload.reload();
  });

  // force run
  gulp.run(['app-styles', 'app-scripts']);
};