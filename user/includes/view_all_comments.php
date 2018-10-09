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

$query = "SELECT * FROM comments WHERE comment_post_id IN (SELECT post_id FROM posts WHERE post_user = '{$user}')";
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

            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";

            $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
            $select_post_id_query = $connection->query($query);
            confirmQuery($select_post_id_query);

            if($select_post_id_query->num_rows == 0) {
                $post_title = "";
            } else {

            while($row = $select_post_id_query->fetch_assoc()) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
            }
        }
        echo "<td><a href='../post.php?p_id={$comment_post_id}'>{$post_title}</a></td>";

            echo "<td>{$comment_date}</td>";
            echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";     
            echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";

            ?>

            <form action="" method="post">
                
                <input type="hidden" name="delete_comment_id" value="<?php echo $comment_id; ?>">

            <?php
                echo "<td><input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";
            ?>

            </form>

            <?php 
            
            echo "</tr>";
        }

 ?>
    </tbody>
</table>

</form>

<?php 

if(isset($_POST['delete'])) {
    $delete_comment_id = $_POST['delete_comment_id'];
    $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
    $delete_comment_id = $connection->query($query);
    confirmQuery($delete_comment_id);
    header("Location: comments.php");
}

if(isset($_GET['approve'])) {
    $the_comment_id = $_GET['approve'];
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id}";
    $comment_status_query = $connection->query($query);
    confirmQuery($comment_status_query);
    header("Location: comments.php");
}

if(isset($_GET['unapprove'])) {
    $the_comment_id = $_GET['unapprove'];
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id}";
    $comment_status_query = $connection->query($query);
    confirmQuery($comment_status_query);
    header("Location: comments.php");
}


 ?>