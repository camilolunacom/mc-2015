var gulp = require('gulp');
var sass = require('gulp-ruby-sass');

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

gulp.task('default', function(){
	gulp.watch('wp-content/themes/mc2015/css/*.sass', ['sass']);
});