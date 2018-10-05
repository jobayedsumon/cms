<?php 

include 'delete_modal.php';

if(isset($_POST['checkBoxArray'])) {

    foreach($_POST['checkBoxArray'] as $post_value_id) {

        $bulkOptions = $_POST['bulkOptions'];

        switch ($bulkOptions) {

            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulkOptions}' WHERE post_id = {$post_value_id}";
                $update_to_published_status = $connection->query($query);
                confirmQuery($update_to_published_status);
                break;
            
            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulkOptions}' WHERE post_id = {$post_value_id}";
                $update_to_draft_status = $connection->query($query);
                confirmQuery($update_to_draft_status);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$post_value_id}";
                $delete_post = $connection->query($query);
                confirmQuery($delete_post);

                break;

            case 'clone':

                $query = "SELECT * FROM posts WHERE post_id = {$post_value_id}";
                $select_posts = mysqli_query($connection, $query);
                confirmQuery($select_posts);

                while($row = mysqli_fetch_assoc($select_posts)) {

                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    $post_tags = $row['post_tags'];
                    $post_status = $row['post_status'];
                    $post_category_id = $row['post_category_id'];
                    $post_comment_count = $row['post_comment_count'];
                }

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";

    $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', '{$post_user}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', {$post_comment_count}, '{$post_status}')";

                $clone_post_query = $connection->query($query);
                confirmQuery($clone_post_query);

            break;

        }
    }

}

?>

<form action="" method="post">

<table class="table table-borderd table-hover">

        <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px;">
            
            <select name="bulkOptions" id="" class="form-control">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name=submit class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>




                <thead>
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>ID</th>
                    <th>Users</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Images</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>View Post</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Views</th>
                </tr>
                </thead>
                <tbody>



<?php 

//$query = "SELECT * FROM posts ORDER BY post_id DESC ";
$query = "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_user, posts.post_date, posts.post_image, posts.post_content, posts.post_tags, posts.post_status, posts.post_views_count, ";
$query .= "categories.cat_id, categories.cat_title FROM posts ";
$query .= "LEFT OUTER JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";

        $select_all_posts = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_all_posts)) {

            $post_id = $row['post_id'];
            $post_category_id = $row['post_category_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_user = $row['post_user'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_status = $row['post_status'];
            $post_views_count = $row['post_views_count'];
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<tr>";

            ?>
<td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
            <?php

            echo "<td>{$post_id}</td>";


            if(isset($post_author) || !empty($post_author)) {

                echo "<td>{$post_author}</td>";

            } elseif(isset($post_user) || !empty($post_user)) {

                echo "<td>{$post_user}</td>";

            }

            echo "<td>{$post_title}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td>{$post_status}</td>";
            echo "<td><img width='100px' src='../images/{$post_image}' alt='image'></td>";
            echo "<td>{$post_tags}</td>";

            $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
            $post_comment_query = $connection->query($query);
            $row = $post_comment_query->fetch_assoc();
            $comment_id = $row['comment_id'];
            $post_comment_count = $post_comment_query->num_rows;


            echo "<td><a href='post_comments.php?id={$post_id}'>{$post_comment_count}</a></td>";


            echo "<td>{$post_date}</td>";
            echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</a></td>";     
            echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&post_id={$post_id}'>Edit</a></td>";     
            
            ?>

            <form action="" method="post">
                
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

            <?php
                echo "<td><input class='btn btn-danger delete_link' type='submit' name='delete' value='Delete'></td>";
            ?>

            </form>

            <?php

            echo "<td><a onClick=\" javascript: return confirm('Are you sure you want to reset?') \" href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
            
            echo "</tr>";
        }

 ?>

    </tbody>
</table>

</form>

<?php 

if(isset($_POST['delete'])) {
    $delete_post_id = $_POST['post_id'];
    $query = "SELECT post_image FROM posts WHERE post_id = {$delete_post_id}";
    $select_post_query = $connection->query($query);
    confirmQuery($select_post_query);

    while($row = mysqli_fetch_assoc($select_all_posts)) {
        $post_image = $row['post_image'];
    }

    $delete_image =  $_SERVER['DOCUMENT_ROOT'].'/cms/images/'.$post_image;
    unlink($delete_image);

    $query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
    $delete_post_query = $connection->query($query);
    confirmQuery($delete_post_query);
    header("Location: posts.php");
}

if(isset($_GET['reset'])) {
    $the_post_id = $connection->real_escape_string($_GET['reset']);
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$the_post_id}";
    $reset_post_views = $connection->query($query);
    confirmQuery($reset_post_views);
    header("Location: posts.php");
}



 ?>

 <script>
     
    $(document).ready(function() {

        $(".delete_link").on('click', function() {
           
            var id = $(this).attr("name");
            var delete_url = $.post("view_all_posts.php", "delete");

            $(".modal_delete_link").attr("href", delete_url);

            $("#exampleModal").modal("show");
        });

    });

 </script>