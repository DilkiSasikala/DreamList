<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Wish List </title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

<div class="container">
</div>
<div class="page">
</div>

<script type="text/template" id="login-template">
<div class="login-container">
    <div class="row">
        <div class="col-md-5 mx-auto p-0">
            <div class="card login-card">
                <div class="login-box">
                    <div class="login-snip">
                        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Login</label>
                        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
                        <div class="login-space">
                            <div class="login">
                                <form>
                                <div class="group">
                                    <label for="login-user" class="label">Username</label>
                                    <input id="login-user" type="text" class="form-control" placeholder="Enter your username">
                                </div>
                                <div class="group">
                                    <label for="login-pass" class="label">Password</label>
                                    <input id="login-pass" type="password" class="form-control" data-type="password" placeholder="Enter your password">
                                </div>
                                    <div class="group"> <button type="submit" id="login-btn">Login</button> </div>
                                </form>
                                <div class="hr"></div>
                            </div>
                            <div class="sign-up-form">
                                <form class="user-signup-form">
                                <div class="group">
                                    <label for="reg-user" class="label">Username</label>
                                    <input id="reg-user" type="text" class="form-control" placeholder="Create your Username" name="username">
                                </div>
                                <div class="group">
                                    <label for="reg-pass" class="label">Password</label>
                                    <input id="reg-pass" type="password" class="form-control" data-type="password" placeholder="Create your password" name="password">
                                </div>
                                <div class="group">
                                    <label for="rep-pass" class="label">Repeat Password</label>
                                    <input id="rep-pass" type="password" class="form-control" data-type="password" placeholder="Re-enter your password" name="confirm_password">
                                </div>
                                <div class="group">
                                    <label for="full-name" class="label">Full Name</label>
                                    <input id="full-name" type="text" class="form-control" placeholder="Enter your full name" name="full_name">
                                </div>
                                <div class="group">
                                    <label for="wishlist_name" class="label">Wishlist Name</label>
                                    <input id="wishlist_name" type="text" class="form-control" placeholder="Enter wishlist name" name="wishlist_name">
                                </div>
                                <div class="group">
                                    <label for="wishlist_description" class="label">Wishlist Description</label>
                                    <input id="wishlist_description" type="text" class="form-control" placeholder="Enter wishlist description" name="wishlist_description">
                                </div>
                                    <div class="group"> <button type="submit" id="signup-btn">Sign Up</button> </div>
                                </form>
                                <div class="hr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</script>

<script type="text/template" id="wishlist-template">
    <nav class="navbar fixed-top navbar-dark bg-light">
        <a class="navbar-brand mx-auto" href="#wishlist">Hello there  <%=username%>!!</a>
        <ul class="nav navbar-nav navbar-right">
            <li><a class="btn logout" role="button" href="#logout"> Logout</a></li>
        </ul>
    </nav>

    <div class="content-area">
            <h1 class="main-title">Dream List</h1>
        <div class="create-button">
            <button id="create-btn">Create wishlist</button>
        </div>
        <hr>
        <div class="list-name-and-dis">
            <h2 class="wishlist-name">Wishlist name: <%=wishlist_name%></h2>
            <h6 class="wishlist-desc">Wishlist description: <%=wishlist_description%></h6>
        </div>


    <div class="yes_item">

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">Item Name</th>
                <th scope="col">Priority <a id="sort"><i class="fas fa-chevron-down"></i></a></th>
                <th scope="col">Reason</th>
                <th scope="col">Price</th>
                <th scope="col">Link to Item</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody class="table-body">
            <% app.wishlist.each(function (item) { %>
            <tr>
                <td class="header-text"><%=item.attributes.item_name%></td>
                <td>
                    <%if(item.attributes.priority_id=='1'){%>
                    Must Have
                    <%}else if(item.attributes.priority_id=='2'){%>
                    Nice to Have
                    <%}else{%>
                    If You Can<%}%>
                </td>
                <td>
                    <%if(item.attributes.wish_category_id=='1'){%>
                    Birthday
                    <%}else if(item.attributes.wish_category_id=='2'){%>
                    Christmas
                    <%}else if(item.attributes.wish_category_id=='3'){%>
                    Wedding
                    <%}else if(item.attributes.wish_category_id=='4'){%>
                    Moving House
                    <%}else{%>
                    Baby shower<%}%>
                </td>
                <td>Rs.<%=item.attributes.price%></td>
                <td><a href="<%=item.attributes.item_url%>" class="url-btn"  target="_blank">Click to View Item</a> </p></td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm" id="edit-btn" data-id="<%=item.attributes.id%>"><i class="fas fa-edit"></i> Edit Item</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" id="delete-btn" data-id="<%=item.attributes.id%>"> <i class="fas fa-trash-alt"></i> Delete</button>
                </td>
            </tr>
            <% }); %>
            </tbody>
        </table>

    </div>

        <div id="no_item">
            <div class="card">
                <div class="card-body no-list">
                    <h1>OH NO!!!</h1>
                    <p>There's nothing in the wish list... </p>
                    <p>Hurry up and create one...</p>
                    <i class="far fa-surprise fa-7x"></i>
                </div>
            </div>
        </div>
    </div>

    <div id="share-btn">
        <button id="btn-share"><i class="fas fa-share-square"></i> Share your wishlist to let others know</button>
    </div>


    <div class="modal" id="create-form">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Create your wishlist</h5>
                    <button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="category">Select Wishlist Reason</label>
                            <select class="form-control" id="category">
                                <% app.categorylist.each(function (category) { %>
                                <option value="<%= category.attributes.id%>"><%= category.attributes.category_type %></option>
                                <% }); %>
<!--                                <option selected>Select...</option>-->
<!--                                <option value="1">Birthday</option>-->
<!--                                <option value="2">Christmas</option>-->
<!--                                <option value="3">Wedding</option>-->
<!--                                <option value="3">Moving House</option>-->
<!--                                <option value="3">Baby Shower</option>-->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item_name">Item Name</label>
                            <input type="text" id="item_name" class="form-control" placeholder="Enter item name" name="item_name">
                        </div>
                        <div class="form-group">
                            <label for="item_url">URL</label>
                            <input class="form-control" type="text" id="item_url" placeholder="Enter a url of the item" name="item_url">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" min="1" class="form-control" id="price" placeholder="Enter price of the item" name="price">
                        </div>
                        <div class="form-group">
                            <label for="priority">Select Priority level</label>
                            <select class="form-control" id="priority">
                                <% app.prioritylist.each(function (priority) { %>
                                <option value="<%= priority.attributes.id%>"><%= priority.attributes.priority_type %></option>
                                <% }); %>
<!--                                <option selected>Select...</option>-->
<!--                                <option value="1">Must Have</option>-->
<!--                                <option value="2">Nice to Have</option>-->
<!--                                <option value="3">If You Can</option>-->
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="enter-wishlist">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="edit-form"> </div>

    <div class="modal" id="share-container">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header share-header">
                    <h5 class="modal-title" id="exampleModalLabel">Copy the link and share</h5>
                    <button type="button" class="close close-share" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a href="#share/<%=id%>" target="_blank">http://localhost:8080/2017413/Wishlist/#share/<%=id%></a>
                </div>
            </div>
        </div>
    </div>


    <footer class="mainfooter" role="contentinfo">
        <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h4>Follow Us</h4>
                        <ul class="social-network social-circle">
                            <li><a href="https://www.facebook.com/" class="icoFacebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://www.linkedin.com/" class="icoLinkedin" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 copy">
                        <p class="text-center">&copy; Copyright 2021 - Server Side CW.  All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


</script>

<!--<script type="text/template" id="footer-template">-->
<!---->
<!--    <footer class="mainfooter" role="contentinfo">-->
<!--        <div class="footer-middle">-->
<!--            <div class="container">-->
<!--                <div class="row">-->
<!--                    <div class="col">-->
<!--                        <h4>Follow Us</h4>-->
<!--                        <ul class="social-network social-circle">-->
<!--                            <li><a href="https://www.facebook.com/" class="icoFacebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>-->
<!--                            <li><a href="https://www.linkedin.com/" class="icoLinkedin" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <br>-->
<!--                <div class="row">-->
<!--                    <div class="col-md-12 copy">-->
<!--                        <p class="text-center">&copy; Copyright 2021 - Server Side CW.  All rights reserved.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </footer>-->
<!---->
<!--</script>-->

<!--<script type="text/template" id="list-template">-->
<!---->
<!--    <div class="card border-info mb-3">-->
<!--        <h5 class="card-header"><%=item_name%></h5>-->
<!--        <div class="card-body text-info">-->
<!--            <h5 class="card-title">Special title treatment</h5>-->
<!--            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>-->
<!--            <a href="#" class="btn btn-primary">Go somewhere</a>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--</script>-->


<script type="text/template" id="edit-template">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Edit your wishlist</h5>
                    <button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="edit-category">Select Wishlist Reason</label>
                            <select class="form-control" id="edit-category">
                                <option value="1"<%if(wish_category_id==1){%>selected<%}%>>Birthday</option>
                                <option value="2"<%if(wish_category_id==2){%>selected<%}%>>Christmas</option>
                                <option value="3"<%if(wish_category_id==3){%>selected<%}%>>Wedding</option>
                                <option value="4"<%if(wish_category_id==4){%>selected<%}%>>Moving House</option>
                                <option value="5"<%if(wish_category_id==5){%>selected<%}%>>Baby Shower</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_name">Item Name</label>
                            <input type="text" id="edit_item_name" class="form-control" value="<%=item_name%>" placeholder="Enter item name" name="edit_item_name">
                        </div>
                        <div class="form-group">
                            <label for="edit_item_url">URL</label>
                            <input class="form-control" type="text" id="edit_item_url" value="<%=item_url%>" placeholder="Enter a url of the item" name="edit_item_url">
                        </div>
                        <div class="form-group">
                            <label for="edit_price">Price</label>
                            <input type="number" min="1" class="form-control" id="edit_price" value="<%=price%>" placeholder="Enter price of the item" name="edit_price">
                        </div>
                        <div class="form-group">
                            <label for="edit_priority">Select Priority level</label>
                            <select class="form-control" id="edit_priority">
                                <option value="1"<%if(priority_id==1){%>selected<%}%>>Must Have</option>
                                <option value="2"<%if(priority_id==2){%>selected<%}%>>Nice to Have</option>
                                <option value="3"<%if(priority_id==3){%>selected<%}%>>If You Can</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="enter-edit">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</script>



<script type="text/template" id="share-template">

    <h1 class="main-title" id="main-title-share">Dream List</h1>
    <div class="list-name-and-dis">
    <h2 class="share-name">Welcome!! You are viewing the wishlist of <%=app.userShare.attributes.data.full_name%></h2>
    <h2 class="wishlist-name">Wishlist name: <%=app.userShare.attributes.data.wishlist_name%></h2>
    <h6 class="wishlist-desc">Wishlist description: <%=app.userShare.attributes.data.wishlist_description%></h6>
    </div>

    <br>
    <div class="yes-list">
        <table class="table" id="share-table">
            <thead class="thead-light">
            <tr>
                <th scope="col">Item Name</th>
                <th scope="col">Priority <a id="sort"><i class="fas fa-chevron-down"></i></a></th>
                <th scope="col">Reason</th>
                <th scope="col">Price</th>
                <th scope="col">Link to Item</th>
            </tr>
            </thead>
            <tbody class="table-body">
            <% app.list.each(function (item) { %>
            <tr>
                <td class="header-text"><%=item.attributes.item_name%></td>
                <td>
                    <%if(item.attributes.priority_id=='1'){%>
                    Must Have
                    <%}else if(item.attributes.priority_id=='2'){%>
                    Nice to Have
                    <%}else{%>
                    If You Can<%}%>
                </td>
                <td>
                    <%if(item.attributes.wish_category_id=='1'){%>
                    Birthday
                    <%}else if(item.attributes.wish_category_id=='2'){%>
                    Christmas
                    <%}else if(item.attributes.wish_category_id=='3'){%>
                    Wedding
                    <%}else if(item.attributes.wish_category_id=='4'){%>
                    Moving House
                    <%}else{%>
                    Baby shower<%}%>
                </td>
                <td>Rs.<%=item.attributes.price%></td>
                <td><a href="<%=item.attributes.item_url%>" class="url-btn"  target="_blank">Click to View Item</a> </p></td>
            </tr>
            <% }); %>
            </tbody>
        </table>
    </div>

    <div id="no-wish-list">
            <div class="card">
                <div class="card-body no-list">
                    <h1>OH NO!!!</h1>
                    <p>There's nothing in the wish list... </p>
                    <i class="far fa-surprise fa-7x"></i>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

</script>


<script src="<?php echo base_url(); ?>assets/js/lib/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/underscore-min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/lib/backbone-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://kit.fontawesome.com/97327e6699.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script src="<?php echo base_url(); ?>assets/js/models/User.js"></script>
<script src="<?php echo base_url(); ?>assets/js/models/Wishlist.js"></script>
<script src="<?php echo base_url(); ?>assets/js/collections/Wishlist_Collection.js"></script>
<script src="<?php echo base_url(); ?>assets/js/views/LoginView.js"></script>
<script src="<?php echo base_url(); ?>assets/js/views/WishlistView.js"></script>
<script src="<?php echo base_url(); ?>assets/js/views/ShareView.js"></script>
<script src="<?php echo base_url(); ?>assets/js/routers/AppRouter.js"></script>

</body>

</html>
