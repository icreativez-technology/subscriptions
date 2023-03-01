let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'platform/plugins/' + directory;
const dist = 'public/vendor/core/plugins/' + directory;

mix
    .sass(source + '/resources/assets/sass/subscription.scss', dist + '/css')
    .js(source + '/resources/assets/js/subscription.js', dist + '/js');

if (mix.inProduction()) {
    mix
        .copy(dist + '/css/subscription.css', source + '/public/css')
        .copy(dist + '/js/subscription.js', source + '/public/js');
}
