
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">


                <?php 

                if(isset($_GET['category'])) {
                    $post_category_id = $_GET['category'];
                }

                $query1 = "SELECT post_id, post_author, post_title, post_date, post_image, post_content FROM posts WHERE post_category_id = ? ";
                $query2 = "SELECT post_id, post_author, post_title, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?";
                $published = 'published';

                if(isset($_SESSION['username'])) {
                    if(is_admin($_SESSION['username'])) {
                        $stmt1 = $connection->prepare($query1);
                            if(!$stmt1) echo "ERROR: ".$connection->error;
                    } else {
                        $stmt2 = $connection->prepare($query2);
                    }
                } else {
                    $stmt2 = $connection->prepare($query2);
                }

                if(isset($stmt1)) {
                    $stmt1->bind_param("i", $post_category_id);
                    $stmt1->execute();
                    $stmt1->bind_result($post_id, $post_author, $post_title, $post_date, $post_image, $post_content);
                    $stmt = $stmt1;
                }
                    
                if(isset($stmt2)) {
                    $stmt2->bind_param("is", $post_category_id, $published);
                    $stmt2->execute();
                    $stmt2->bind_result($post_id, $post_author, $post_title, $post_date, $post_image, $post_content);
                    $stmt = $stmt2;
                }

                
                while($stmt->fetch()):
             
                    ?>


                    <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"> <?php echo $post_title; ?> </a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src= "/cms/images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>


            <?php endwhile;

            if($stmt->num_rows < 1) {
                echo "<h1 class='text-center'>No Post Available</h1>";
            }

            $stmt->close();

              ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>