let mix = require("laravel-mix");
require("laravel-mix-splitjs");
// mix.options({ purifyCss: true });
require("laravel-mix-purgecss");
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
// mix.react('resources/assets/js/app.js', 'public/js')
// mix.react('resources/assets/js/auth.js', 'public/js/auth/app.js')
// .react('resources/assets/js/blog.js', 'public/js/blog/app.js')
mix.react('resources/assets/js/dashboard.js', 'public/js/dashboard/app.js')
// .react('resources/assets/js/inbox.js', 'public/js/inbox/app.js')
// mix.react('resources/assets/js/ListingDetail.js', 'public/js/ListingDetail/app.js')
// mix.react('resources/assets/js/aboutus.js', 'public/js/aboutus/app.js')

// mix.react('resources/assets/js/pricing.js', 'public/js/pricing/app.js')
// mix.react('resources/assets/js/help.js', 'public/js/help/app.js')
mix.react(
  "resources/assets/js/managelisting.js",
  "public/js/managelisting/app.js"
);
// mix.react('resources/assets/js/search.js', 'public/js/search/app.js')
// mix.react('resources/assets/js/map.js', 'public/js/map/app.js')
// mix.react('resources/assets/js/contactus.js', 'public/js/contactus/app.js').extract()

mix
  .sass("resources/assets/sass/app.scss", "public/css", {
    implementation: require("node-sass")
  })
  .purgeCss();
