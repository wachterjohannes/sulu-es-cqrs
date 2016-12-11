define(['underscore', 'jquery', 'text!/admin/content/template/form.html?type=app_page'], function(_, $, form) {

    var formId = '#content-form';

    return {

        defaults: {
            templates: {
                form: form,
                url: '/admin/api/pages<% if (!!id) { %>/<%= id %><% } %>?locale=<%= locale %>'
            },
            translations: {
                title: 'public.title'
            }
        },

        layout: {
            extendExisting: true,

            content: {
                width: 'fixed',
                rightSpace: false,
                leftSpace: false
            }
        },

        initialize: function() {
            this.render();

            this.bindDomEvents();
            this.bindCustomEvents();
        },

        render: function() {
            this.$el.html(this.templates.form({translations: this.translations}));

            this.form = this.sandbox.form.create(formId);
            this.form.initialized.then(function() {
                var data = this.data || {};

                this.sandbox.form.setData(formId, data || {}).then(function() {
                    this.sandbox.start(this.$el, {reset: true});
                }.bind(this));
            }.bind(this));
        },

        bindDomEvents: function() {
            this.sandbox.dom.on(this.$el, 'keyup', _.debounce(this.setDirty.bind(this), 10), 'input, textarea');
            this.sandbox.dom.on(this.$el, 'change', _.debounce(this.setDirty.bind(this), 10), 'input[type="checkbox"], select');
            this.sandbox.on('sulu.content.changed', this.setDirty.bind(this));
        },

        setDirty: function() {
            this.sandbox.emit('sulu.tab.dirty');
        },

        bindCustomEvents: function() {
            this.sandbox.on('sulu.tab.save', this.save.bind(this));
        },

        save: function() {
            if (!this.sandbox.form.validate(formId)) {
                return;
            }

            var data = this.sandbox.form.getData(formId),
                url = this.templates.url({id: this.data.id, locale: this.options.locale});

            // TODO dynamic
            data.template = 'default';

            this.sandbox.util.save(url, !this.data.id ? 'POST' : 'PUT', data).then(function(response) {
                this.sandbox.emit('sulu.tab.saved', response);
            }.bind(this));
        },

        loadComponentData: function() {
            var promise = $.Deferred();

            promise.resolve(this.options.data());

            return promise;
        }
    };
});
