var app = app || {};
app.views = {};
app.routers = {};
app.models = {};
app.collections = {};
app.status = {};
app.base_url = 'http://localhost:8080/2017413/Wishlist/index.php/api/';


$(document).ready(function () {
    app.appRouter = new app.routers.AppRouter();
    $(function () {
        Backbone.history.start();
    });
});