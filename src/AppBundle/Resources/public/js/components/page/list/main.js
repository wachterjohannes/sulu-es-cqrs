define(['text!./list.html'], function(list) {

    var defaults = {
        templates: {
            list: list
        }
    };

    return {

        defaults: defaults,

        header: function() {
            return {
                title: 'app.pages',
                underline: false,

                toolbar: {
                    buttons: {
                        add: {},
                        deleteSelected: {}
                    },

                    languageChanger: {
                        preSelected: this.options.locale
                    }
                }
            };
        },

        layout: {
            content: {
                width: 'max'
            }
        },

        initialize: function() {
            this.render();

            this.bindCustomEvents();
        },

        render: function() {
            this.$el.html(this.templates.list());

            this.sandbox.sulu.initListToolbarAndList.call(this,
                'pages',
                '/admin/api/pages/fields',
                {
                    el: this.$find('#list-toolbar-container'),
                    instanceName: 'pages',
                    template: this.sandbox.sulu.buttons.get({
                        settings: {
                            options: {
                                dropdownItems: [
                                    {
                                        type: 'columnOptions'
                                    }
                                ]
                            }
                        }
                    })
                },
                {
                    el: this.sandbox.dom.find('#page-list'),
                    url: '/admin/api/pages?locale=' + this.options.locale,
                    searchInstanceName: 'pages',
                    searchFields: ['title', 'content'],
                    resultKey: 'pages',
                    instanceName: 'pages',
                    actionCallback: this.toEdit.bind(this),
                    viewOptions: {
                        table: {
                            actionIconColumn: 'title'
                        }
                    }
                }
            );
        },

        toList: function(locale) {
            this.sandbox.emit('sulu.router.navigate', 'pages/' + locale);
        },

        toEdit: function(id) {
            this.sandbox.emit('sulu.router.navigate', 'pages/' + this.options.locale + '/edit:' + id + '/details');
        },

        toAdd: function() {
            this.sandbox.emit('sulu.router.navigate', 'pages/' + this.options.locale + '/add');
        },

        deleteItems: function(ids) {
            for (var i = 0, length = ids.length; i < length; i++) {
                this.deleteItem(ids[i]);
            }
        },

        deleteItem: function(id) {
            this.sandbox.util.save('/admin/api/pages/' + id, 'DELETE').then(function() {
                this.sandbox.emit('husky.datagrid.pages.record.remove', id);
            }.bind(this));
        },

        bindCustomEvents: function() {
            this.sandbox.on('sulu.toolbar.add', this.toAdd.bind(this));

            this.sandbox.on('husky.datagrid.pages.number.selections', function(number) {
                var postfix = number > 0 ? 'enable' : 'disable';
                this.sandbox.emit('sulu.header.toolbar.item.' + postfix, 'deleteSelected', false);
            }.bind(this));

            this.sandbox.on('sulu.toolbar.delete', function() {
                this.sandbox.emit('husky.datagrid.pages.items.get-selected', this.deleteItems.bind(this));
            }.bind(this));

            this.sandbox.on('sulu.header.language-changed', function(item) {
                this.toList(item.id);
            }.bind(this));
        }
    };
});
