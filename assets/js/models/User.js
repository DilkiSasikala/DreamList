var app = app || {};
app.models.User = Backbone.Model.extend({
    urlRoot : app.base_url+'Authentication/',
    defaults :{
        id: null,
        username: "",
        password: "",
        full_name: "",
        wishlist_name: "",
        wishlist_description: ""
    }
})