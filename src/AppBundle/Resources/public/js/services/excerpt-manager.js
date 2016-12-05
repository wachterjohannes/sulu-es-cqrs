define(['jquery', 'underscore', 'services/husky/util'], function($, _, Util) {

    var template = _.template('/admin/api/pages/<%= id %>/excerpt');

    return {
        load: function(id) {
            return Util.load(template({id: id}));
        },

        save: function(pageId, data) {
            return Util.save(template({id: pageId}), !data.id ? 'POST' : 'PUT', data);
        }
    };
});
