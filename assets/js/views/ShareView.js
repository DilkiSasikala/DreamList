var app = app || {};

app.views.ShareView = Backbone.View.extend({
    el: ".page",

    initialize: function () {},

    render: function () {
        template = _.template($('#share-template').html());
        this.$el.html(template(app.userShare.attributes));
        // console.log(app.userShare.attributes.data);
        if(this.collection.length == 0){
            $("#no-wish-list").css('display', 'block');
        }
        this.collection.each(function (wishlist) {
            $(".yes-list").css('display', 'block');
        });
    },

    events:{
        "click #sort" : "sort",
        // "click #sort2" : "sort2"
    },

    sort: function (e){
        e.preventDefault();
        console.log("click")
        console.log(this.collection)
        this.collection.comparator = 'priority_id';
        this.collection.sort();
        this.render();
    },
    // sort2: function (e){
    //     e.preventDefault();
    //     console.log("click")
    //     console.log(this.collection)
    //     this.collection.comparator = 'priority_id';
    //     this.collection.sort();
    //     this.render();
    // }
});