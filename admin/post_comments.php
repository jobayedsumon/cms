<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

    <!-- Navigation -->
<?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                 <div class="col-lg-12">
                    <h1 class="page-header">
                    Welcome to Comments
                    <small><?php echo $_SESSION['username']; ?></small>
                    </h1>

<?php bulkComments(); ?>

<form action="" method="post">

<table class="table table-borderd table-hover">

    <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px;">
            
            <select name="bulkOptions" id="" class="form-control">
                <option value="">Select Options</option>
                <option value="approved">Approve</option>
                <option value="unapproved">Unapprove</option>
                <option value="delete">Delete</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name=submit class="btn btn-success" value="Apply">
        </div>


        <thead>
        <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>ID</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>




<?php 

if(isset(escape($_GET['id'])) && !empty(escape($_GET['id']))) {


$query = "SELECT * FROM comments WHERE comment_post_id = " . $connection->real_escape_string($_GET['id']) . " ";
        $select_all_comments = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_all_comments)) {

            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];


            echo "<tr>";

            ?>
<td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $comment_id; ?>"></td>
            <?php

            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_content}</td>";
/*
            $query = "SELECT cat_title FROM categories WHERE cat_id = {$post_category_id}";
            $select_category = mysqli_query($connection, $query);
            confirmQuery($select_category);
            $row = $select_category->fetch_assoc();
            $cat_title = $row['cat_title'];

            echo "<td>{$cat_title}</td>";
*/

            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";

            $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
            $select_post_id_query = $connection->query($query);

            while($row = $select_post_id_query->fetch_assoc()) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
            echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
        }



            echo "<td>{$comment_date}</td>";
            echo "<td><a href='post_comments.php?approve={$comment_id}&id=" . escape($_GET['id']) . "'>Approve</a></td>";     
            echo "<td><a href='post_comments.php?unapprove={$comment_id}&id=" . escape($_GET['id']) . "'>Unapprove</a></td>";     
            echo "<td><a  href='post_comments.php?delete={$comment_id}&id=" . escape($_GET['id']) . "'>Delete</a></td>";
            
            echo "</tr>";
        }

    } else {
        header("Location: posts.php");
    }

 ?>


    </tbody>
</table>

</form>

<?php 

if(isset(escape($_GET['delete']))) {
    $delete_comment_id = escape($_GET['delete']);
    $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
    $delete_comment_id = $connection->query($query);
    confirmQuery($delete_comment_id);
    header("Location: post_comments.php?id=" . escape($_GET['id']);
}

if(isset(escape($_GET['approve']))) {
    $the_comment_id = escape($_GET['approve']);
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id}";
    $comment_status_query = $connection->query($query);
    confirmQuery($comment_status_query);
    header("Location: post_comments.php?id=" . escape($_GET['id']);
}

if(isset(escape($_GET['unapprove']))) {
    $the_comment_id = escape($_GET['unapprove']);
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id}";
    $comment_status_query = $connection->query($query);
    confirmQuery($comment_status_query);
    header("Location: post_comments.php?id=" . escape($_GET['id']);
}


 ?>

            </div>
            </div>
            <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
<!-- /#wrapper -->

<?php include "includes/admin_footer.php"; ?>
