var app = app || {};

app.views.LoginView = Backbone.View.extend({
    el: ".container",


    render: function () {
        template = _.template($('#login-template').html());
        this.$el.html(template);
    },

    events: {
        "click #signup-btn" : "register",
        "click #login-btn" : "login"
    },

    register: function (e) {
        e.preventDefault();
        var user = new app.models.User;
        var regData = {
            'username': $("#reg-user").val(),
            'password': $("#reg-pass").val(),
            'confirm_password': $("#rep-pass").val(),
            'full_name': $("#full-name").val(),
            'wishlist_name': $("#wishlist_name").val(),
            'wishlist_description': $("#wishlist_description").val()
         };

        user.set(regData);
        console.log(user.attributes);
        user.save(user.attributes,{
            "url": user.urlRoot + "signup",
            success: function (model, response, options){
                // console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                });
                app.appRouter.navigate("#", {trigger: true})
                $("input").val("");
            },
            error: function (model, xhr, options) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: xhr.responseJSON.message
                })
            }
        })
    },

    login: function (e) {
        e.preventDefault();
        var user = new app.models.User;
        var userData = {
            'username': $("#login-user").val(),
            'password': $("#login-pass").val()
        };
        user.set(userData);
        user.save(user.attributes,{
            "url": user.urlRoot + "login",
            success: function (model, response, options) {
                // console.log(model);
                localStorage.setItem("user", JSON.stringify(model.attributes.data));
                app.appRouter.navigate('#wishlist',{trigger: true, replace: true});
            },
            error:function (model, xhr, options) {
                console.log(xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: xhr.responseJSON.message
                })
            }
        })
    }

});