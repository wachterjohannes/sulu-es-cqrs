define(['jquery'], function($) {

    'use strict';

    return {

        defaults: {
            templates: {
                url: '/admin/api/pages<% if (!!id) { %>/<%= id %><% } %>?locale=<%= locale %>'
            },
            translations: {
                headline: 'app.page'
            }
        },

        header: function() {
            return {
                tabs: {
                    url: '/admin/content-navigations?alias=pages',
                    options: {
                        locale: this.options.locale,
                        data: function() {
                            return this.sandbox.util.extend(false, {}, this.data);
                        }.bind(this)
                    },
                    componentOptions: {
                        values: this.data
                    }
                },

                toolbar: {
                    buttons: {
                        save: {
                            parent: 'saveWithOptions'
                        }
                    },

                    languageChanger: {
                        preSelected: this.options.locale
                    }
                }
            };
        },

        loadComponentData: function() {
            var promise = $.Deferred();

            if (!this.options.id) {
                promise.resolve({});

                return promise;
            }
            this.sandbox.util.load(_.template(this.defaults.templates.url, {
                id: this.options.id,
                locale: this.options.locale
            })).done(function(data) {
                promise.resolve(data);
            });

            return promise;
        },

        initialize: function() {
            this.bindCustomEvents();
        },

        bindCustomEvents: function() {
            this.sandbox.on('sulu.header.back', this.toList.bind(this));
            this.sandbox.on('sulu.tab.dirty', this.enableSave.bind(this));
            this.sandbox.on('sulu.toolbar.save', this.save.bind(this));
            this.sandbox.on('sulu.tab.data-changed', this.setData.bind(this));

            this.sandbox.on('sulu.header.language-changed', function(item) {
                if (!!this.options.id) {
                    this.toEdit(this.options.id, item.id);
                } else {
                    this.toAdd(item.id);
                }
            }.bind(this));
        },

        save: function(action) {
            this.loadingSave();

            this.saveTab().then(function(data) {
                this.afterSave(action, data);
            }.bind(this));
        },

        setData: function(data) {
            this.data = data;
        },

        saveTab: function() {
            var promise = $.Deferred();

            this.sandbox.once('sulu.tab.saved', function(savedData) {
                this.setData(savedData);

                promise.resolve(savedData);
            }.bind(this));

            this.sandbox.emit('sulu.tab.save');

            return promise;
        },

        enableSave: function() {
            this.sandbox.emit('sulu.header.toolbar.item.enable', 'save', false);
        },

        loadingSave: function() {
            this.sandbox.emit('sulu.header.toolbar.item.loading', 'save');
        },

        toList: function() {
            this.sandbox.emit('sulu.router.navigate', 'pages/' + this.options.locale);
        },

        toEdit: function(id, locale) {
            this.sandbox.emit('sulu.router.navigate', 'pages/' + (locale || this.options.locale) + '/edit:' + id + '/details');
        },

        toAdd: function(locale) {
            this.sandbox.emit('sulu.router.navigate', 'pages/' + (locale || this.options.locale) + '/add');
        },

        afterSave: function(action, data) {
            this.sandbox.emit('sulu.header.toolbar.item.disable', 'save', true);
            this.sandbox.emit('sulu.header.saved', data);

            if (action === 'back') {
                this.toList();
            } else if (action === 'new') {
                this.toAdd();
            } else if (!this.options.id) {
                this.toEdit(data.id);
                this.sandbox.emit('sulu.router.navigate', 'pages/edit:' + data.id + '/details');
            }
        }
    };
});
