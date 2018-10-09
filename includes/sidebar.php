<?php 

    if(isMethod('post')) {

        if(isset($_POST['login'])) {

            if(isset($_POST['username']) && isset($_POST['password'])) {
                login_user($_POST['username'], $_POST['password']);

            } else {
                redirect('/cms/index.php');
            }
        }
    }

 ?>



<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <div class="input-group">
            <form action="search.php" method="post">
            <input type="text" name="search" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit" name="submit">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
            </form>
        </div>
        <!-- /.input-group -->
    </div>





    <div class="well">

        <?php if(isset($_SESSION['user_role'])): ?>

            <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
            <a href="includes/logout.php" class="btn btn-primary">Logout</a>

        <?php else: ?>

        <h4>Login</h4>
            <form action="" method="post">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Enter Username">
            </div>
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="login">Submit</button>
                </span>
            </div>

            <div class="form-group">
                <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot password</a>
            </div>
            </form>

        <?php endif; ?>

    </div>


    

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">


            <?php

            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_categories)) {

                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];

                echo "<li><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
            } 

            ?>

                    
                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <div class="well">
        <h4>Social Media</h4>

        <div class="addthis_inline_share_toolbox"></div>

    </div>

</div>

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5bb1ea84df52eabf"></script>