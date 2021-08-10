var app = app || {};
app.collections.WishlistCollection = Backbone.Collection.extend({
    url : app.base_url + 'Wishlist/',
    model : app.models.Wishlist
})

app.collections.WishCategory = Backbone.Collection.extend({
    url : app.base_url + 'WishCategory/',
    model : app.models.WishCategory
})

app.collections.Priority = Backbone.Collection.extend({
    url : app.base_url + 'Priority/',
    model : app.models.Priority
})