let mix = require('laravel-mix');
var elixir = require('laravel-elixir');
elixir(function(mix) {
    mix.react('resources/assets/js/app.js', 'public/js')
        .sass('resources/assets/sass/app.scss', 'public/css');
})