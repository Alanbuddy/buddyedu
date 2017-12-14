let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/admin_course.scss', 'public/css')
	.sass('resources/assets/sass/auth-course-index.scss', 'public/css')
	.sass('resources/assets/sass/review.scss', 'public/css')
	.sass('resources/assets/sass/org-manage.scss', 'public/css')
	.sass('resources/assets/sass/auth-show.scss', 'public/css')
	.sass('resources/assets/sass/teacher-show.scss', 'public/css')
	.sass('resources/assets/sass/student-show.scss', 'public/css')
	.sass('resources/assets/sass/edu-point.scss', 'public/css')
	.sass('resources/assets/sass/agent-add.scss', 'public/css')
	.sass('resources/assets/sass/auth-course-add.scss', 'public/css')
	.sass('resources/assets/sass/agent-edu-add.scss', 'public/css')
	.sass('resources/assets/sass/agent-teacher-add.scss', 'public/css')
	.sass('resources/assets/sass/info.scss', 'public/css')
	.sass('resources/assets/sass/profile.scss', 'public/css')
	.sass('resources/assets/sass/student-product.scss', 'public/css')
	.sass('resources/assets/sass/student-course.scss', 'public/css')
	.sass('resources/assets/sass/student-course-review.scss', 'public/css')
	.sass('resources/assets/sass/mobile-course-show.scss', 'public/css')
	.sass('resources/assets/sass/class_info.scss', 'public/css');
   // .sass('resources/assets/sass/app.scss', 'public/css');
