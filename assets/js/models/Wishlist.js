var app = app || {};
app.models.Wishlist = Backbone.Model.extend({
    urlRoot: app.base_url + 'Wishlist/',
    defaults: {
        id: null,
        user_id: null,
        wish_category_id: null,
        priority_id: null,
        item_name: "",
        item_url: "",
        price: "",
        // category_type: "",
        // priority_type: ""
    }
});

app.models.WishCategory = Backbone.Model.extend({
    urlRoot: app.base_url + ' WishCategory/',
    defaults: {
        id: null,
        category_type: ""
    }
});


app.models.Priority = Backbone.Model.extend({
    urlRoot: app.base_url + ' Priority/',
    defaults: {
        id: null,
        priority_type: ""
    }
});