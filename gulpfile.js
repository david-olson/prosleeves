/** 
 * @desc Gulpfile for ProSleeves WordPress theme
 * @author David Olson
 * @version 1.0.0
 */

////////////////////
// Set Up Project
// Config
////////////////////

var project 		= 'prosleeves',
	url				= 'pro-sleeves:5555',
	bower			= 'bower_components',
	build			= '../sparketh_production',
	buildInclude	= [
		'**/*.php',
		'**/*.html',
		'**/*.css',
		'**/*.js',
		'**/*.svg',
		'**/*.ttf',
		'**/*.otf',
		'**/*.eot',
		'**/*.woff',
		'**/*.woff2',
		//Exclude files and folders
		'!.gitignore',
		'!.git/**/*',
		'!**/.DS_Store',
		'!node_modules/**/*',
		'!bower_components',
		'!style.css.map',
		'!assets/js/custom/*',
		'!assets/css/src/partials/*'
	];

////////////////////
// Load Plugins
////////////////////

var gulp			= require('gulp'),
	browserSync		= require('browser-sync'),
	autoprefixer	= require('gulp-autoprefixer'),
	minifycss		= require('gulp-uglifycss'),
	filter			= require('gulp-filter'),
	uglify			= require('gulp-uglify'),
	newer			= require('gulp-newer'),
	ignore			= require('gulp-ignore'),
	rimraf 			= require('gulp-rimraf'),
	rename			= require('gulp-rename'),
	concat			= require('gulp-concat'),
	runSequence		= require('gulp-run-sequence'),
	sass			= require('gulp-sass'),
	plumber			= require('gulp-plumber'),
	mainBowerFiles	= require('gulp-main-bower-files'),
	zip				= require('gulp-zip');

////////////////////
// Tasks
////////////////////

// ************ //
// BrowserSync
// ************ //

gulp.task('browser-sync', function() {
	var files = [
		'**/*.php',
		'**/*.html',
		'**/*.{png,jpg,gif,svg}'
	];
	browserSync.init(files, {
		port: 8181,
		proxy: url,
		injectChanges: true
	});
});

// ************ //
// Styles
// ************ //

gulp.task('styles', function() {
	gulp.src('./assets/css/src/*.scss')
		.pipe(plumber())
		.pipe(sass({
			errLogToConsole: true,
			outputStyle: 'compact',
			precision: 10
		}))
		.pipe(autoprefixer('last 3 version', '> 1%', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(plumber.stop())
		.pipe(gulp.dest('./assets/css/build'))
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(minifycss({
			maxLineLen: 80
		}))
		.pipe(gulp.dest('./assets/css/build'))
		.pipe(browserSync.stream());
});

// ************ //
// Vendor Scripts
// ************ //

gulp.task('vendorsJs', function() {
	return gulp.src(['./bower.json'])
		.pipe(mainBowerFiles({
			overrides: {
				// scrollmagic: {
				// 	main: [
				// 		'./scrollmagic/minified/ScrollMagic.min.js',
				// 		'./scrollmagic/minified/plugins/animation.gsap.min.js',
				// 		'./scrollmagic/minified/plugins/debug.addIndicators.min.js'
				// 	]
				// },
				jquery: {
					ignore: true
				}
			}
		}))
		.pipe(filter('**/*.js'))
		.pipe(concat('vendors.js'))
		.pipe(gulp.dest('./assets/js/build'))
		.pipe(rename({
			basename: 'vendors',
			suffix: '.min'
		}))
		.pipe(uglify().on('error', function(e) {
			console.log(e);
		}))
		.pipe(gulp.dest('./assets/js/build'));
});

// ************ //
// User Scripts
// ************ //

gulp.task('scriptsJs', function() {
	return gulp.src('./assets/js/src/*.js')
		.pipe(concat('main.js'))
		.pipe(gulp.dest('./assets/js/build'))
		.pipe(rename({
			basename: 'main',
			suffix: '.min'
		}))
		.pipe(uglify())
		.pipe(gulp.dest('./assets/js/build'));
});

gulp.task('clear', function() {
	cache.clearAll();
});

gulp.task('cleanup', function() {
	return gulp.src(['./assets/bower_components', '**/.sass-cache', '**/.DS_Store'], {
		read: false
	})
	.pipe(ignore('node_modules/**'))
	.pipe(rimraf({
		force: true
	}));
});

gulp.task('cleanupFinal', function() {
    return gulp.src(['./assets/bower_components', '**/.sass-cache', '**/.DS_Store'], {
            read: false
        })
        .pipe(ignore('node_modules/**'))
        .pipe(rimraf({
            force: true
        }))
});

gulp.task('buildFiles', function() {
    return gulp.src(buildInclude)
        .pipe(gulp.dest(build));
});

gulp.task('buildImages', function() {
    return gulp.src(['assets/images/**/*', '!assets/images/raw/**'])
        .pipe(gulp.dest(build + '/assets/images/'));
});

gulp.task('buildZip', function() {
    return gulp.src(build + '/**/')
        .pipe(zip(project + '.zip'))
        .pipe(gulp.dest('../'));
});

gulp.task('build', function(cb) {
    runSequence('styles', 'cleanup', 'vendorsJs', 'scriptsJs', 'buildFiles', 'buildImages', 'buildZip', 'cleanupFinal', cb);
});

gulp.task('default', ['styles', 'vendorsJs', 'scriptsJs', 'browser-sync'], function() {
	gulp.watch('./assets/css/**/*.scss', ['styles']);
	gulp.watch('./assets/js/**/*.js', ['scriptsJs', browserSync.reload]);
});