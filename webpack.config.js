var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    // ----- USER ----- //
    .addEntry('app_user_js', './assets/_user/js/app.js')
    .addEntry('app_user_js_demo', './assets/_user/js/app_demo.js')
    .addEntry('app_user_js_calculate_coins', './assets/_user/js/pages/payments/calculate_coins.js')
    .addStyleEntry('app_user_css', './assets/_user/css/app.scss')
    .addStyleEntry('app_user_css_demo', './assets/_user/css/app_demo.scss')
    .copyFiles({
        from: './assets/_user/images/',
        pattern: /static.(png|jpg|jpeg|gif)$/,
        to: './images/static/_user/[path]/[name].[hash:8].[ext]'
    })
    // ----- ADMINLTE ----- //
    .addEntry('adminlte_js', './assets/adminlte/js/app.js')
    .addEntry('adminlte_js_promotion', './assets/adminlte/js/Pages/promotion/promotion.js')
    .addStyleEntry('adminlte_css', './assets/adminlte/css/app.css')
    .copyFiles({
        from: './assets/adminlte/images/',
        pattern: /static.(png|jpg|jpeg|gif)$/,
        to: './images/static/adminlte/[path]/[name].[hash:8].[ext]'
    })
    // ----- CKEDITOR ----- //
    .copyFiles([
        {
            from: './node_modules/ckeditor/',
            to: 'ckeditor/[path][name].[ext]',
            pattern: /\.(js|css)$/,
            includeSubdirectories: false
        },
        {from: './node_modules/ckeditor/adapters', to: 'ckeditor/adapters/[path][name].[ext]'},
        {from: './node_modules/ckeditor/lang', to: 'ckeditor/lang/[path][name].[ext]'},
        {from: './node_modules/ckeditor/plugins', to: 'ckeditor/plugins/[path][name].[ext]'},
        {from: './node_modules/ckeditor/skins', to: 'ckeditor/skins/[path][name].[ext]'}
    ])
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()

    .autoProvidejQuery()

module.exports = Encore.getWebpackConfig();
