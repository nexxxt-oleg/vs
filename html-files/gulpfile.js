var browserSync = require('browser-sync');
var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var cache = require('gulp-cache');
var cleanCSS = require('gulp-clean-css');
var cssbeautify = require('gulp-cssbeautify');
var imagemin = require('gulp-imagemin');
var notify = require('gulp-notify');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var stylelint = require('gulp-stylelint');
var eslint = require('gulp-eslint');
var snippets = require('sass-snippets');

var watchSassFiles = ['sass/**/*.+(sass|scss)', '!sass/new-bootstrap/**/*.+(sass|scss)'];
var watchJsFiles = ['js/**/*.js', '!js/libs/*.js'];
var watchHtmlFiles = '**/*.html';
var watchImgFile = ['img/**/*', 'content/**/*'];

// Browser Synk
gulp.task('browser-sync', function() {
	browserSync({ server: true, notify: false });
});

// Слежение за JS
gulp.task('dev-js', function() {
	return gulp.src(watchJsFiles)
		.pipe(eslint({
			"globals": [
				"jQuery",
				"$"
			]
		})) // Проверка линтом
		.pipe(eslint.format()) // Вывод ошибок в консоль
		.pipe(browserSync.reload({stream: true}));
});

// SASS Компиляция
gulp.task('dev-sass', function() {
	return gulp.src(watchSassFiles)
		.pipe(stylelint({
			failAfterError: false,
			reportOutputDir: 'reports/stylelint',
			reporters: [
				{
					formatter: 'string',
					console: true
				}
			]
		}).on('error', notify.onError())) // Проверка линтом
		.pipe(sass({
			includePaths: snippets.includePaths
		}).on('error', notify.onError())) // Преобразование sass в css
		.pipe(autoprefixer(['last 15 versions'])) // Добавление префиксов
		.pipe(cssbeautify({indent: '	'})) // Форматирование кода
		.pipe(gulp.dest('css')) // Перемещение в папку css
		.pipe(browserSync.reload({stream: true})); // Обновление страницы
});

gulp.task('watch', ['dev-sass', 'dev-js', 'browser-sync'], function() {
	gulp.watch(watchSassFiles, ['dev-sass']);
	gulp.watch(watchJsFiles, ['dev-js']);
	gulp.watch(watchHtmlFiles, browserSync.reload);
});

// Сжатие js
gulp.task('build-js', function() {
	return gulp.src(watchJsFiles)
		.pipe(uglify()) // Минификация кода
		.pipe(rename({suffix: '.min', prefix : ''})) // Добавление суффикса .min к названию файла
		.pipe(gulp.dest('js')); // Перемещение в папку js
});

// Сжатие css
gulp.task('build-sass', function() {
	return gulp.src(watchSassFiles)
		.pipe(sass({
			includePaths: snippets.includePaths
		}).on('error', notify.onError())) // Преобразование sass в css
		.pipe(autoprefixer(['last 15 versions'])) // Добавление префиксов
		.pipe(cleanCSS()) // Минификация кода
		.pipe(rename({suffix: '.min', prefix : ''})) // Добавление суффикса .min к названию файла
		.pipe(gulp.dest('css')); // Перемещение в папку css
});

// Компиляция
gulp.task('build', ['build-sass', 'build-js']);

// Минификация изображений
gulp.task('imagemin', function() {
	return gulp.src(watchImgFile)
		.pipe(cache(imagemin())) // Кэширование и минификация изображений
		.pipe(gulp.dest('img-min')); // Перемещение в папку img-min
});

gulp.task('default', ['watch']);
