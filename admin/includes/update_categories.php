<form action="" method="post">
    <div class="form-group">
        <label>Edit Category</label>

    <?php

        if(isset($_GET['edit'])) {

            $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
            $select_all_categories = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_all_categories)) {

                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];

     ?>

        <input value="<?php if(isset($cat_title)) echo $cat_title; ?>" type="text" name="cat_title" class="form-control">

  <?php  }} ?>

  <?php 

    if(isset($_POST['update'])) {
        $cat_title = escape($_POST['cat_title']);
        $query = "UPDATE categories SET cat_title = ? WHERE cat_id = ?";
        $stmt = $connection->prepare($query);
        if(!$stmt)
            die("QUERY FAILED ".$connection->error);
        $stmt->bind_param("si", $cat_title, $cat_id);
        $stmt->execute();
        header("Location: categories.php");
    }

   ?>

    </div>
    <input type="submit" name="update" class="btn btn-primary" value="Update Category">

    </form>