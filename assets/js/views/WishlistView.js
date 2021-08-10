var app = app || {};

app.views.WishlistView = Backbone.View.extend({
    el: ".container",

    initialize: function () {},

    render: function () {
        console.log("render");
        // template_footer = _.template($('#footer-template').html());
        // $(".page").append(template_footer);
        template = _.template($('#wishlist-template').html());
        this.$el.html(template(app.user.attributes));

        if(this.collection.wishlist.length == 0){
            $("#no_item").css('display', 'block');
        }
        this.collection.wishlist.each(function (wishlist) {
            // app.listDisplay = new app.views.ListDisplayView({model: wishlist});
            // app.listDisplay.render();
            // console.log(wishlist)
            $("#yes_item").css('display', 'block');
        });
    },

    events: {
        "click #create-btn" : "toggleCreateForm",
        "click .close" : "closeCreateForm",
        "click #enter-wishlist" : "addWishlist",
        "click #edit-btn" : "editWishlist",
        "click #delete-btn" : "deleteWishlist",
        "click #btn-share" : "shareWishList",
        "click .close-share" : "closeShareList",
        "click #sort" : "sort",
    },

    toggleCreateForm: function (){
        $("#create-form").css('display', 'block');
    },
    closeCreateForm: function (){
        $("#create-form").css('display', 'none');
    },
    addWishlist: function (e) {
        e.preventDefault();
        var wishdata = {
            'wish_category_id': $("#category").val(),
            'item_name': $("#item_name").val(),
            'item_url': $("#item_url").val(),
            'price': $("#price").val(),
            'priority_id': $("#priority").val(),
            'user_id': app.user.get('id'),
        }
        userData = JSON.parse(localStorage.getItem("user"));
        var addItem = new app.models.Wishlist(wishdata);
        addItem.save(addItem.attributes,{
            "url": addItem.urlRoot + "wishlist",
            headers:  {'Authorization': userData.token},
            success: function (model, response, options) {
                console.log(response.id)
                addItem.set({id:response.id});

                // //get the category name
                // app.categorylist.fetch({
                //     "url": app.categorylist.url + "oneCategory/" +model.attributes.wish_category_id,
                //     headers:  {'Authorization': userData.token},
                //     wait: true,
                //     success: function (collection, response) {
                //         console.log(response)
                //         addItem.set({category_type:response});
                //
                //         //get the priority name
                //         app.prioritylist.fetch({
                //             "url": app.prioritylist.url + "onePriority/" +model.attributes.priority_id,
                //             headers:  {'Authorization': userData.token},
                //             wait: true,
                //             success: function (collection, response) {
                //                 console.log(response)
                //                 addItem.set({priority_type:response});
                //
                //                 console.log(addItem)
                //                 app.wishlist.push(addItem);
                //                 // app.wishlist.comparator = 'status_id';
                //                 app.wishlistView.closeCreateForm();
                //                 app.wishlistView.render();
                //             },
                //             error: function (model, xhr, options) {
                //                 console.log(xhr)
                //                 app.appRouter.navigate("#", {trigger: true, replace: true});
                //                 localStorage.clear();
                //             }
                //         })
                //     },
                //     error: function (model, xhr, options) {
                //         console.log(xhr)
                //         app.appRouter.navigate("#", {trigger: true, replace: true});
                //         localStorage.clear();
                //     }
                // });
                app.wishlist.push(addItem);
                // app.wishlist.comparator = 'priority_id';
                // app.wishlist.sort();
                // console.log(addItem)
                app.wishlistView.closeCreateForm();
                app.wishlistView.render();
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                });
            },
            error:function (model, xhr, options) {
                if (xhr.status == 401) {
                    // app.appRouter.navigate("#", {trigger: true, replace: true});
                    window.location.href = "";
                    localStorage.clear();
                } else if(xhr.status == 400){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: xhr.responseJSON.message
                    })
                } else if(xhr.status == 500) {
                    console.log(xhr)
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.statusText
                    })
                }
            }
        })
    },

    sort: function (e){
        e.preventDefault();
        // console.log("click")
        // console.log(this.collection)
        app.wishlist.comparator = 'priority_id';
        app.wishlist.sort();
        this.render();
    },

    editWishlist : function (e) {
        e.preventDefault();
        e.stopPropagation();
        // var id = e.target.getAttribute("data-id")
        var editList= app.wishlist.get(e.target.getAttribute("data-id"));
        // console.log(editList);
        app.editForm = new app.views.ListEditView({model: editList});
        // console.log(app.editForm);
        app.editForm.render();
    },

    deleteWishlist: function(e) {
        e.preventDefault();
        var deleteList= app.wishlist.get(e.target.getAttribute("data-id"));
        console.log(deleteList.attributes.id)
        deleteList.destroy({
            "url": deleteList.urlRoot + "deleteList/"+deleteList.attributes.id,
            headers:  {'Authorization': userData.token},
            success: function (model, response, options) {
                console.log(response);
                app.wishlist.remove(deleteList);
                app.wishlistView.render();
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                });
            },
            error:function (model, xhr, options) {
                if (xhr.status == 401) {
                    // app.appRouter.navigate("#", {trigger: true, replace: true});
                    window.location.href = "";
                    localStorage.clear();
                }
            }
        })
    },

    shareWishList: function () {
        $("#share-container").css('display', 'block');
    },

    closeShareList: function () {
        $("#share-container").css('display', 'none');
    }
});



app.views.ListEditView = Backbone.View.extend({
    el: "#edit-form",
    events: {
        "click .close" : "closeEditForm",
        "click #enter-edit" : "editForm"
    },
    render: function () {
        console.log("edit view")
        template = _.template($('#edit-template').html());
        this.$el.html(template(this.model.attributes));
        // this.$el.css('display', 'block');
        console.log(this.model.attributes.user_id)
        $("#edit-form").css('display', 'block');

    },

    closeEditForm: function (){
        $("#edit-form").css('display', 'none');
    },

    editForm: function (e){
        e.preventDefault();
        var wishdata = {
            'id' : this.model.attributes.id ,
            'wish_category_id': $("#edit-category").val(),
            'item_name': $("#edit_item_name").val(),
            'item_url': $("#edit_item_url").val(),
            'price': $("#edit_price").val(),
            'priority_id': $("#edit_priority").val(),
            'user_id': this.model.attributes.user_id,
        }
        var editList = new app.models.Wishlist(wishdata);
        console.log(editList.attributes);
        editList.save(editList.attributes,{
            "url": editList.urlRoot + "updateList",
            headers:  {'Authorization': userData.token},
            success: function (model, response, options) {
                app.wishlist.set([editList, editList.attributes], {remove: false});
                // app.list.comparator = 'status_id';
                // app.list.sort();
                $("#edit-form").css('display', 'none');
                app.wishlistView.render();
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                });
            },
            error:function (model, xhr, options) {
                if (xhr.status == 401) {
                    // app.appRouter.navigate("#", {trigger: true, replace: true});
                    window.location.href = "";
                    localStorage.clear();
                } else if(xhr.status == 400){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: xhr.responseJSON.message
                    })
                } else if(xhr.status == 500) {
                    console.log(xhr)
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.statusText
                    })
                }
            }
        });
    }
});