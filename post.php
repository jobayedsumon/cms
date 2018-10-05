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

        if(isset($_GET['p_id']))  {

            $post_id = $_GET['p_id'];

            $query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = {$post_id}";
            $post_view_query = $connection->query($query);
            if(!$post_view_query) {
                die("QUERY FAILED ".$connection->error);
            }

            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {

                $query = "SELECT * FROM posts WHERE post_id = {$post_id}";

            } else {
                $query = "SELECT * FROM posts WHERE post_id = {$post_id} AND post_status = 'published'";
            }

            $select_all_posts = mysqli_query($connection, $query);

            if($select_all_posts->num_rows < 1) {
                        echo "<h1 class='text-center'>No post is available</h1>";
            } else {

        while($row = mysqli_fetch_assoc($select_all_posts)) {

            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_title = $row['post_title'];

            ?>


            <h1 class="page-header">
            Page Heading
            <small>Secondary Text</small>
        </h1>

        <!-- First Blog Post -->
        <h2>
            <a href="#"> <?php echo $post_title; ?> </a>
        </h2>
        <p class="lead">
            by <a href="index.php"><?php echo $post_author; ?></a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
        <hr>
        <img class="img-responsive" src= "/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
        <hr>
        <p><?php echo $post_content; ?></p>
        

        <hr>

    <?php } ?>

        <!-- Comments Form -->
        
<?php 


    if(isset($_POST['create_comment'])) {

        $post_id = $_GET['p_id'];

        $comment_author = $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];

        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
        
        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";

        $query .= "VALUES ({$post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now())";

        $create_comment_query = $connection->query($query);
        if(!$create_comment_query) {
            die("QUERY FAILED " . $connection->error);
        }

        echo "<h4 class='bg-info'>Your comment will be appeard after approving</h4>";


    } else {

        echo "<script> alert('Fields cannot be empty'); </script>";
    }
}


?>

        <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form" action="" method="post">
                 <div class="form-group">
                    <label for="comment_author">Author</label>
                    <input type="text" name="comment_author" class="form-control">
                </div>
                 <div class="form-group">
                    <label for="comment_email">Email</label>
                    <input type="text" name="comment_email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="comment_content">Your Comment</label>
                    <textarea class="form-control" rows="3" name="comment_content"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
            </form>
        </div>

        <hr>


    <?php 

     $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} AND comment_status = 'approved'";
     $query .= "ORDER BY comment_id DESC";
        $select_post_comment = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_post_comment)) {
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_date = $row['comment_date'];

     ?>

    <div class="media">
        <a class="pull-left" href="#">
            <img class="media-object" src="http://placehold.it/64x64" alt="">
        </a>
        <div class="media-body">

            <h4 class="media-heading"><?php echo $comment_author; ?>
                <small><?php echo $comment_date; ?></small>
            </h4>
            <?php echo $comment_content; ?>
        </div>
    </div>


 <?php } } } else {
    header("Location: index.php");
 } ?>

    

    </div>


    <!-- Blog Sidebar Widgets Column -->
    <?php include "includes/sidebar.php"; ?>

</div>
<!-- /.row -->

<hr>

<?php include "includes/footer.php"; ?>