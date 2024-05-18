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

 /*mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');*/

mix.styles([
   "css/normalize.css",
   "css/ext-all.css",
   "css/iconos.css",
   "css/combos.css",
   "css/fileuploadfield.css",
   "css/xtheme-slate.css"
], 'css/app.css');

mix.scripts([
   "js/ext-base.js",
   "js/ext-all.js",
   "js/ext-lang-es.js",
   "js/ux-all.js",
   "js/funciones_comunes/paqueteComun.js",
   "js/util.js",
   "js/jQuery-2.1.4.min.js",
   "js/highcharts.js",
   "js/highcharts-3d.js",
   "js/funciones_comunes/Ext.util.JSON.js",
   "js/funciones_comunes/SuperBoxSelect.js"
], 'js/app.js');
