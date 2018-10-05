<?php 

if(isset($_GET['post_id'])) {
	$edit_post_id = $_GET['post_id'];
}


$query = "SELECT * FROM posts WHERE post_id = {$edit_post_id}";
        $select_all_posts = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_all_posts)) {

            $post_title = $row['post_title'];
            $post_user = $row['post_user'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_status = $row['post_status'];
            $post_category_id = $row['post_category_id'];

        }

 ?>

<?php 

if(isset($_POST['update_post'])) {

    $post_title = $_POST['post_title'];
    $post_user = $_POST['post_user'];
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    $post_status = $_POST['post_status'];
    $post_category_id = $_POST['post_category_id'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];

    move_uploaded_file($post_image_tmp, "../images/{$post_image}");

    if(empty($post_image)) {
    	$query = "SELECT post_image FROM posts WHERE post_id = {$edit_post_id}";
    	$result = $connection->query($query);
    	$row = $result->fetch_assoc();
    	$post_image = $row['post_image'];
    }

    $query = "UPDATE posts SET ";
    $query .= "post_category_id = {$post_category_id}, ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_user = '{$post_user}', ";
    $query .= "post_date = now(), ";
	$query .= "post_image = '{$post_image}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_status = '{$post_status}' ";
    $query .= "WHERE post_id = {$edit_post_id} ";

    $update_query = $connection->query($query);
    confirmQuery($update_query);

    echo "<p class='bg-success'>Post Updated:. <a href='../post.php?p_id=$edit_post_id'>View Post</a> or <a href='posts.php'>Edit More Post</a></p>";
}

?>


<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="post_title">Post Title</label>
		<input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
	</div>
	
	<div class="form-group">
		<label for="post_category_id">Post Category</label>
		<select name="post_category_id" class="form-control">
			
	<?php 

		$query = "SELECT * FROM categories";
        $select_all_categories = mysqli_query($connection, $query);
        confirmQuery($select_all_categories);

        while($row = mysqli_fetch_assoc($select_all_categories)) {
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];

            if($cat_id == $post_category_id) {

                echo "<option selected value='$cat_id'>{$cat_title}</option>";

            } else {
                echo "<option value='$cat_id'>{$cat_title}</option>";
            }
       }

	?>
		</select>
	</div>


<!--
	<div class="form-group">
		<label for="post_user">Post Author</label>
		<input value="<?php //echo $post_user; ?>" type="text" class="form-control" name="post_user">
	</div>
-->

<div class="form-group">
        <label for="users">Users</label>
        <select name="post_user" class="form-control">
            
    <?php 

    echo "<option value='$post_user'>{$post_user}</option>";

        $query = "SELECT * FROM users";
        $select_all_users = mysqli_query($connection, $query);
        confirmQuery($select_all_users);

        while($row = mysqli_fetch_assoc($select_all_users)) {
            $username = $row['username'];
            $user_id = $row['user_id'];

           echo "<option value='$username'>{$username}</option>";
       }

    ?>
        </select>
    </div>



	<div class="form-group">
        
        <select name="post_status" class="form-control">
            <option value="<?php echo $post_status; ?>"><?php echo ucfirst($post_status); ?></option>
            <?php 
                if($post_status == 'draft')
                    echo "<option value='published'>Publish</option>";
                else
                    echo "<option value='draft'>Draft</option>";
             ?>
        </select>

    </div>
	<div class="form-group">
		<img width="100px" src="../images/<?php echo $post_image; ?>" alt="image">
		<input type="file" name="post_image">
	</div>
	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
	</div>
	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea name="post_content" class="form-control" cols="30" POSTs="10"><?php echo $post_content; ?></textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
	</div>




</form>