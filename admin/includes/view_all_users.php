<table class="table table-borderd table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody>


<?php 

$query = "SELECT * FROM users";
        $select_all_users = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_all_users)) {

            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password= $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];


            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";
/*
            $query = "SELECT cat_title FROM categories WHERE cat_id = {$post_category_id}";
            $select_category = mysqli_query($connection, $query);
            confirmQuery($select_category);
            $row = $select_category->fetch_assoc();
            $cat_title = $row['cat_title'];

            echo "<td>{$cat_title}</td>";
*/

            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";


            echo "<td><a href='users.php?change_to_admin=$user_id'>Admin</a></td>";     
            echo "<td><a href='users.php?change_to_sub=$user_id'>Subscriber</a></td>";     
            echo "<td><a class = 'btn btn-info' href='users.php?source=edit_user&edit_user=$user_id'>Edit</a></td>";

            ?>

            <form action="" method="post">
                
                <input type="hidden" name="delete_user_id" value="<?php echo $user_id; ?>">

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

<?php 

if(isset($_POST['delete'])) {
    if($_SESSION['user_role'] == 'admin') {
        $delete_user_id = $_POST['delete_user_id'];
        $query = "DELETE FROM users WHERE user_id = {$delete_user_id}";
        $delete_user_id = $connection->query($query);
        confirmQuery($delete_user_id);
        header("Location: users.php");
    } else {
        header("Location: ../index.php");
    }
}

if(isset($_GET['change_to_admin'])) {
    $the_user_id = $_GET['change_to_admin'];
    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$the_user_id}";
    $user_role_change_query = $connection->query($query);
    confirmQuery($user_role_change_query);
    header("Location: users.php");
}

if(isset($_GET['change_to_sub'])) {
    $the_user_id = $_GET['change_to_sub'];
    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$the_user_id}";
    $user_role_change_query = $connection->query($query);
    confirmQuery($user_role_change_query);
    header("Location: users.php");
}


 ?>