<?php 

if(isset($_POST['create_post'])) {

    $post_category_id = $_POST['post_category_id'];
    $post_title = $_POST['post_title'];
    $post_user = $_POST['post_user'];
    $post_date = date('d-m-y');
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];

    move_uploaded_file($post_image_tmp, "../images/{$post_image}");

    $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";

    $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', 0, '{$post_status}')";

    $create_post_query = $connection->query($query);

    confirmQuery($create_post_query);

    $last_id = $connection->insert_id;

    echo "<p class='bg-success'>Post Created: <a href='../post.php?p_id=$last_id'>View Post</a> or <a href='posts.php'>Edit More Post</a></p>";

}


 ?>




<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="post_title">Post Title</label>
		<input type="text" class="form-control" name="post_title">
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

           echo "<option value='$cat_id'>{$cat_title}</option>";
       }

	?>
		</select>
	</div>




<!--
	<div class="form-group">
		<label for="post_author">Post Author</label>
		<input type="text" class="form-control" name="post_author">
	</div>
-->

<div class="form-group">
		<label for="users">Users</label>
		<select name="post_user" class="form-control">
			
	<?php 

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
			<option value="draft">Post Status</option>
			<option value="draft">Draft</option>
			<option value="published">Published</option>
		</select>

	</div>

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="post_image">
	</div>
	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>
	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea name="post_content" class="form-control" cols="30" POSTs="10"></textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
	</div>




</form>