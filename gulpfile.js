var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var autoprefixer = require('gulp-autoprefixer');

gulp.task('sass', function(){
	return gulp.src('wp-content/themes/mc2015/css/styles.sass')
		.pipe(sass({
			sourcemap: true
		}))
		.on('error', function(err){
			console.log(err.message);
		})
		.pipe(gulp.dest('wp-content/themes/mc2015/css'));
});

gulp.task('autoprefix', function(){
	return gulp.src('wp-content/themes/mc2015/css/styles.css')
		.pipe(autoprefixer({
			browsers: ['last 10 versions'],
			cascade: false
		}))
		.pipe(gulp.dest('wp-content/themes/mc2015/css'));
});

gulp.task('default', function(){
	gulp.watch('wp-content/themes/mc2015/css/*.sass', ['sass']);
	gulp.watch('wp-content/themes/mc2015/css/styles.css', ['autoprefix']);
});