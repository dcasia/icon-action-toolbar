let mix = require('laravel-mix')
const path = require('path');

require('./nova.mix')
require('mix-tailwindcss')

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'vendor/laravel/nova/resources/js'),
        }
    }
});

console.log('Building Bora Bora Icon Action Toolbar...');

mix
  .setPublicPath('dist')
  .js('resources/js/tool.js', 'js')
  .vue({ version: 3 })
  .postCss('resources/css/tool.css', 'css')
  .tailwind()
  .nova('digital-creative/icon-action-toolbar')
