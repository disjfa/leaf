// webpack.config.js
const Encore = require('@symfony/webpack-encore');
const { InjectManifest } = require('workbox-webpack-plugin');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .addEntry('admin', './assets/admin/js/admin.js')
  .addEntry('site', './assets/site/js/site.js')
  .addStyleEntry('email', './assets/email/email.scss')
  .enableSassLoader()
  .autoProvidejQuery()
  .enableSourceMaps(!Encore.isProduction())
  .enableVueLoader()
  .enableBuildNotifications()
  .enableSingleRuntimeChunk()
  .splitEntryChunks()
  .cleanupOutputBeforeBuild()
  .addPlugin(new InjectManifest({
    // globDirectory: 'public/',
    // globPatterns: ['**/*.{html,js,css,jpg,png,woff2,woff,ttf,json}'],
    swSrc: './assets/sw.js',
    swDest: './../sw.js',
    templatedUrls: {
      'offline.html': 'url'
    }
  }))
;

if (Encore.isProduction()) {
  // Enable post css loader
  Encore
    .enablePostCssLoader()
    .enableVersioning()
  ;
}

// export the final configuration
module.exports = Encore.getWebpackConfig();
