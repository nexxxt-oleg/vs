var gulp           = require('gulp'),
	notify         = require("gulp-notify"),
	cache          = require('gulp-cache'),
	autoprefixer   = require('gulp-autoprefixer'),
	imagemin       = require('gulp-imagemin'),
	sass           = require('gulp-sass'),
	cssbeautify    = require('gulp-cssbeautify'),
	snippets       = require('sass-snippets');

// SASS Компиляция
gulp.task('sass', function() {
	return gulp.src(['sass/**/*.+(sass|scss)','!sass/bootstrap/**/*.+(sass|scss)'])
		.pipe(sass({
        	includePaths: snippets.includePaths
    	}).on("error", notify.onError()))
		.pipe(autoprefixer(['last 15 versions']))
		.pipe(cssbeautify({indent: '	'}))
		.pipe(gulp.dest('css'));
});

gulp.task('watch', ['sass'], function() {
	gulp.watch('sass/**/*.+(sass|scss)', ['sass']);
});

gulp.task('imagemin', function() {
	return gulp.src('img/**/*')
		.pipe(cache(imagemin())) // Cache Images
		.pipe(gulp.dest('img-min'));
});

gulp.task('default', ['watch']);