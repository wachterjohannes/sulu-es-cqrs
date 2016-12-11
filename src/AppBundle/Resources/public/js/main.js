require.config({
    paths: {
        app: '../../app/js'
    }
});

define(function() {

    'use strict';

    return {

        name: 'App Bundle',

        initialize: function(app) {

            app.components.addSource('app', '/bundles/app/js/components');

            app.sandbox.mvc.routes.push({
                route: 'pages',
                callback: function() {
                    app.sandbox.emit('sulu.router.navigate', 'pages/de', true, true);
                }
            });

            app.sandbox.mvc.routes.push({
                route: 'pages/:locale',
                callback: function(locale) {
                    return '<div data-aura-component="page/list@app" data-aura-locale="' + locale + '"/>';
                }
            });

            app.sandbox.mvc.routes.push({
                route: 'pages/:locale/add',
                callback: function(locale) {
                    return '<div data-aura-component="page/edit@app" data-aura-locale="' + locale + '"/>';
                }
            });

            app.sandbox.mvc.routes.push({
                route: 'pages/:locale/edit::id/:content',
                callback: function(locale, id) {
                    return '<div data-aura-component="page/edit@app" data-aura-locale="' + locale + '" data-aura-id="' + id + '"/>';
                }
            });
        }
    };
});
