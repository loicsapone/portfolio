const Encore = require('@symfony/webpack-encore');
const path = require('path');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // path
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    // entries
    .addEntry('app', './assets/app.js')

    // features
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()
    .enablePostCssLoader()

    // babel config
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // dev-server config
    .configureDevServerOptions(options => {
        options.https = {
            pfx: path.join(process.env.HOME, '.symfony/certs/default.p12'),
        }
    })
;

module.exports = Encore.getWebpackConfig();
