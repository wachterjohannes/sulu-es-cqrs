define(['app/services/excerpt-manager'], function(manager) {

    'use strict';

    return {

        type: 'excerpt-tab',

        loadComponentData: function() {
            var data = this.options.data();

            return JSON.parse(JSON.stringify(data.excerpt || {}));
        },

        save: function(data) {
            var content = this.options.data();
            if (!!content.excerpt) {
                data.id = content.excerpt.id || '';
            }
            data.entityId = content.id;

            manager.save(content.id, data, this.options.locale).then(function(data) {
                content.excerpt = data;
                this.sandbox.emit('sulu.tab.saved', content);
            }.bind(this));
        }
    };
});
