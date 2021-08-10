var app = app || {};

app.routers.AppRouter = Backbone.Router.extend({
    routes: {
        "": "login",
        "wishlist": "wishlist",
        "logout": "logout",
        "share/:id" :"share"

    },
    login: function () {
            // app.user = new app.models.User(userJson);
            app.loginView = new app.views.LoginView();
            app.loginView.render();
            console.log("login")
    },

    logout: function () {
        userData = JSON.parse(localStorage.getItem("user"));
        Swal.fire({
            icon: 'success',
            title: "Logout successful",
            text: "Bye" + userData.username + "!"
        });
        localStorage.clear();
        window.location.href = "";
    },

    wishlist: function () {
        userData = JSON.parse(localStorage.getItem("user"));
        if (userData != null) {
            // console.log(userData)
            app.user = new app.models.User(userData);
            app.wishlist = new app.collections.WishlistCollection();
            app.categorylist = new app.collections.WishCategory();
            app.prioritylist = new app.collections.Priority();
            // app.wishlistView = new app.views.WishlistView({collection: app.wishlist});
            app.wishlistView = new app.views.WishlistView({collection: {
                    wishlist: app.wishlist,
                    categorylist: app.categorylist,
                    prioritylist: app.prioritylist
                }
            });
            //fetch category
            app.categorylist.fetch({
                "url": app.categorylist.url + "category/",
                headers:  {'Authorization': userData.token},
                wait: true,
                success: function (collection, response) {
                    console.log("category");
                    //fetch priority
                    app.prioritylist.fetch({
                        "url": app.prioritylist.url + "priority/",
                        headers:  {'Authorization': userData.token},
                        wait: true,
                        success: function (collection, response) {
                            console.log("priority");
                            //fetch wishlist
                            app.wishlist.fetch({
                                "url": app.wishlist.url + "wishlist/" +app.user.get("id"),
                                headers:  {'Authorization': userData.token},
                                wait: true,
                                success: function (collection, response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: "Login successful",
                                        text: "Welcome " + userData.username + "!"
                                    });
                                    app.wishlistView.render();
                                },
                                error: function (model, xhr, options) {
                                    if (xhr.status == 404) {
                                        app.wishlistView.render();
                                        Swal.fire({
                                            icon: 'success',
                                            title: "Login successful",
                                            text: "Welcome " + userData.username + "!"
                                        });
                                        $("#no_item").css('display', 'block');
                                    }else if (xhr.status == 401) {
                                        // app.appRouter.navigate("#", {trigger: true, replace: true});
                                        window.location.href = "";
                                        localStorage.clear();
                                    }
                                }
                            });
                        },
                        error: function (model, xhr, options) {
                            console.log(xhr.responseJSON.message);
                            // app.appRouter.navigate("#", {trigger: true, replace: true});
                            window.location.href = "";
                            localStorage.clear();
                        }
                    });
                },
                error: function (model, xhr, options) {
                    console.log(xhr.responseJSON.message);
                    // app.appRouter.navigate("#", {trigger: true, replace: true});
                    window.location.href = "";
                    localStorage.clear();
                }
            });
            // app.prioritylist.fetch({
            //     "url": app.prioritylist.url + "priority/",
            //     headers:  {'Authorization': userData.token},
            //     wait: true,
            //     success: function (collection, response) {
            //         console.log("priority");
            //         // app.prioritylist.each(function (priority) {
            //         //     app.priority = new app.models.Priority(priority.attributes)
            //         //     console.log(app.priority.attributes)
            //         // })
            //     },
            //     error: function (model, xhr, options) {
            //         console.log(xhr.responseJSON.message);
            //     }
            // });
            // app.wishlist.fetch({
            //     "url": app.wishlist.url + "wishlist/" +app.user.get("id"),
            //     headers:  {'Authorization': userData.token},
            //     wait: true,
            //     success: function (collection, response) {
            //         Swal.fire({
            //             icon: 'success',
            //             title: "Login successful",
            //             text: "Welcome " + userData.username + "!"
            //         });
            //         app.wishlistView.render();
            //     },
            //     error: function (model, xhr, options) {
            //         if (xhr.status == 404) {
            //             app.wishlistView.render();
            //             Swal.fire({
            //                 icon: 'success',
            //                 title: "Login successful",
            //                 text: "Welcome " + userData.username + "!"
            //             });
            //             $("#no_item").css('display', 'block');
            //         }else if (xhr.status == 401) {
            //             app.appRouter.navigate("#", {trigger: true, replace: true});
            //             localStorage.clear();
            //         }
            //     }
            // });

        } else {
            app.appRouter.navigate("#", {trigger: true, replace: true});
        }
    },


    share: function (id) {
        app.userShare = new app.models.User();
        app.list = new app.collections.WishlistCollection();
        app.shareView = new app.views.ShareView({collection: app.list});
        app.userShare.fetch({
            "url": app.userShare.urlRoot + "user/"+id,
            wait: true,
            success: function (model, response, options) {
                console.log(response);

                app.list.fetch({
                    "url": app.list.url+"shareList/"+id,
                    wait: true,
                    success: function (collection, response) {
                        // console.log(app.shareView)
                        app.shareView.render();
                    },
                    error: function (model, xhr, options) {
                        if (xhr.status == 404) {
                            console.log(model)
                            console.log("no list")
                            app.shareView.render();
                            // $("#no-wish-list").css('display', 'block');
                        }else if (xhr.status == 401) {
                            window.location.href = "";
                            localStorage.clear();
                        }
                    }
                })

            },
            error: function (model, xhr, options) {
                console.log(xhr);
            }
        });
    }
})
;
