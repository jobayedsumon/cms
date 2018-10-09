    <?php session_start(); ?>
     <?php  include "admin/functions.php"; ?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                <?php

                $query = "SELECT * FROM categories";
                $select_all_categories = mysqli_query($connection, $query);


                while($row = mysqli_fetch_assoc($select_all_categories)) {

                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    $active_class = '';
                    $pagename = basename($_SERVER['PHP_SELF']);
                    $regpage = 'registration.php';
                    $contact = 'contact.php';
                    $regclass = '';
                    $contactclass = '';

                    if(isset($_GET['category']) && $_GET['category'] == $cat_id ) {

                        $active_class = 'active';
                    } 
                    elseif($pagename == $regpage) {
                        $regclass = 'active';

                    } 
                    elseif($pagename == $contact) {
                        $contactclass = 'active';

                    }

                    echo "<li class='{$active_class}'><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";
                }

                ?>

                <?php if(isLoggedIn()): { ?>

                    <?php if(is_admin($_SESSION['username'])): ?>

                    <li>
                        <a href="/cms/admin">Admin</a>
                    </li>

                    <?php else: ?>
    
                    <li>
                        <a href="/cms/user">Admin</a>
                    </li>

                <?php endif; ?>

                    <li>
                        <a href="/cms/includes/logout.php">Logout</a>
                    </li>

                <?php } ?>

                <?php else: ?>

                    <li>
                        <a href="/cms/login">Login</a>
                    </li>

                <?php endif; ?>



            

            <li class="<?php echo $regclass; ?>">
                <a href="/cms/registration">Registration</a>
            </li>

            <li class="<?php echo $contactclass; ?>">
                <a href="/cms/contact">Contact</a>
            </li>


            <?php

            if(isset($_SESSION['user_role'])) {

                if(isset($_GET['p_id'])) {
                    $the_post_id = $_GET['p_id'];

                    echo "<li><a href='/cms/admin/posts.php?source=edit_post&post_id={$the_post_id}'>Edit Post</a></li>";
                }
            }


             ?>
                



                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>