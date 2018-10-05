<?php

if(isset($_GET['edit_user'])) {

    $the_user_id = $_GET['edit_user'];

    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_user = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_user)) {

            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
        }


    if(isset($_POST['update_user'])) {

        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        if(!empty($user_password)) {

            $query = "SELECT user_password FROM users WHERE user_id = {$the_user_id}";
            $user_password_query = $connection->query($query);
            confirmQuery($user_password_query);
            $row = $user_password_query->fetch_array();
            $db_user_password = $row['user_password'];


            if($db_user_password != $user_password) {

                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
            }

            

            $query = "UPDATE users SET ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_role = '{$user_role}', ";
            $query .= "username = '{$username}', ";
            $query .= "user_password = '{$hashed_password}', ";
            $query .= "user_email = '{$user_email}' ";
            $query .= "WHERE user_id = {$the_user_id}";

            $update_user_query = $connection->query($query);
            confirmQuery($update_user_query);

            echo "Users Updated: " . "<a href='users.php'>View Users</a>";

        }

    }
} else {
    header("Location: index.php");
}

 ?>




<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Fristname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
    </div>

    <div class="form-group">
        <label for="post_title">Lastname</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
    </div>


    <div class="form-group">
        <select id="" name="user_role" class="form-control">

            <option value="<?php echo $user_role; ?>"><?php echo ucfirst($user_role); ?></option>

            <?php 
                if($user_role == "admin")
                    echo "<option value='subscriber'>Subscriber</option>";
                else
                    echo "<option value='admin'>Admin</option>";

             ?>
            
        </select>
    </div>
    
            

    <div class="form-group">
        <label for="post_author">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="form-group">
        <label for="post_status">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" name="user_password" class="form-control" value="">
    </div>
    

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
    </div>




</form>