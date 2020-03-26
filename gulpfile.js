const gulp = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const concat = require('gulp-concat');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');
const sass = require('gulp-ruby-sass');
const uglify = require('gulp-uglify');

gulp.task('sass', function(){
	return sass('wp-content/themes/mc2015/css/styles.sass')
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

gulp.task('minify-css', function(){
	return gulp.src('wp-content/themes/mc2015/css/styles.css')
		.pipe(cleanCSS({compatibility: '*'}))
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest('wp-content/themes/mc2015/css'));
});

gulp.task('autoprefix-min', function(){
	return gulp.src('wp-content/themes/mc2015/css/styles.min.css')
		.pipe(autoprefixer({
			browsers: ['last 10 versions'],
			cascade: false
		}))
		.pipe(gulp.dest('wp-content/themes/mc2015/css'));
});

gulp.task('deal-js', function(){
	return gulp.src([
		'wp-content/themes/mc2015/js/owl.carousel.min.js',
		'wp-content/themes/mc2015/js/screenfull.min.js',
		'wp-content/themes/mc2015/js/main.js'
	])
		.pipe(concat('all.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('wp-content/themes/mc2015/js/'));
});

gulp.task('default', gulp.series('sass', 'autoprefix', 'minify-css', 'autoprefix-min', 'autoprefix-min', 'deal-js'), function(done) {
	gulp.watch('wp-content/themes/mc2015/css/*.sass', ['sass']);
	gulp.watch('wp-content/themes/mc2015/css/styles.css', ['autoprefix']);
	gulp.watch('wp-content/themes/mc2015/css/styles.css', ['minify-css']);
	gulp.watch('wp-content/themes/mc2015/css/styles.min.css', ['autoprefix-min']);
	gulp.watch('wp-content/themes/mc2015/js/main.js', ['deal-js']);
});