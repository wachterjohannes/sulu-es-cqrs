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
                    return '<div data-aura-component="page/list@app"/>';
                }
            });

            app.sandbox.mvc.routes.push({
                route: 'pages/add',
                callback: function() {
                    return '<div data-aura-component="page/edit@app"/>';
                }
            });

            app.sandbox.mvc.routes.push({
                route: 'pages/edit::id/:content',
                callback: function(id) {
                    return '<div data-aura-component="page/edit@app" data-aura-id="' + id + '"/>';
                }
            });
        }
    };
});
