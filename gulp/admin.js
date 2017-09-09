let gulp = require('gulp')
  , sass = require('gulp-sass')
  , concat = require('gulp-concat')
  , cleanCSS = require('gulp-clean-css')
  , rename = require('gulp-rename')
  , livereload = require('gulp-livereload')
  , autoprefixer = require('gulp-autoprefixer');

gulp.task('admin-styles', function () {
  return gulp.src([
    'resources/assets/sass/font-awesome-4.7.0/font-awesome.scss',
    'resources/assets-admin/sass/bootstrap-4/bootstrap.scss',
    'public/lib/fancyBox-3.0/jquery.fancybox.min.css',
    'public/lib/jstree/themes/default/style.min.css',
    'public/lib/jquery-ui-1.11.4/jquery-ui.css',
    'public/lib/bootstrap-datepicker/css/bootstrap-datepicker.min.css',
    'public/lib/jquery-tag-editor/jquery.tag-editor.css',
    'resources/assets-admin/sass/lukas-admin.scss',
    'public/lib/jquery-context-menu/jquery.contextMenu.min.css'
  ])
    .pipe(sass()['on']('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(concat('lukas-admin.min.css'))
    .pipe(cleanCSS({level: {1: {specialComments: 0}}}))
    .pipe(gulp.dest('public/assets-admin/css'))
    .pipe(livereload())
    ;
});

gulp.task('admin-ckeditor-style', function () {
  return gulp.src('resources/assets-admin/sass/ckeditor.scss')
    .pipe(sass()['on']('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(cleanCSS())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('public/assets-admin/css'))
    .pipe(livereload())
    ;
});

module.exports = function () {
  gulp.watch('resources/assets-admin/sass/lukas-admin.scss', ['admin-styles']);
  gulp.watch('resources/assets-admin/sass/ckeditor.scss', ['admin-ckeditor-style']);

  // force run
  gulp.run(['admin-styles', 'admin-ckeditor-style']);
};