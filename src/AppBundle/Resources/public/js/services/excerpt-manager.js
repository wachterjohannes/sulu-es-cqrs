define(['jquery', 'underscore', 'services/husky/util'], function($, _, Util) {

    var template = _.template('/admin/api/pages/<%= id %>/excerpt?locale=<%= locale %>');

    return {
        load: function(id, locale) {
            return Util.load(template({id: id, locale: locale}));
        },

        save: function(pageId, data, locale) {
            return Util.save(template({id: pageId, locale: locale}), !data.id ? 'POST' : 'PUT', data);
        }
    };
});
