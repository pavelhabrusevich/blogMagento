define(['uiComponent'], function (Component) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Habr_Blog/blog'
        },
        initialize: function () {
            this._super();
            console.log(this.title);
            return this
        }
    });
});
