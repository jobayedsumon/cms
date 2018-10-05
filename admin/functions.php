<?php 

function imagePlaceholder($image=0) {

    if(!$image) {

        return 'placeholder.png';
    }

    return $image;
}

function redirect($location) {

    header("Location: ".$location);
    exit;
}

function isMethod($method=null) {

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}

function isLoggedIn() {

    if(isset($_SESSION['user_role'])) {
        return true;
    }
    return false;
}

function isLoggedInAndRedirect() {

    if(isLoggedIn()) {

        if(is_admin($_SESSION['username']))
            redirect("/cms/admin");
        else
            redirect("/cms/user");
    }
}





function escape(string $str) {
    global $connection;
    return $connection->real_escape_string($str);
}

function bulkComments() {

    global $connection;

    if(isset($_POST['checkBoxArray'])) {

    foreach($_POST['checkBoxArray'] as $the_comment_id) {

        $the_comment_id;

        $bulkOptions = escape($_POST['bulkOptions']);

        switch ($bulkOptions) {

            case 'approved':
                $query = "UPDATE comments SET comment_status = '{$bulkOptions}' WHERE comment_id = {$the_comment_id}";
                $update_to_approved_status = $connection->query($query);
                confirmQuery($update_to_approved_status);
                break;
            
            case 'unapproved':
                $query = "UPDATE comments SET comment_status = '{$bulkOptions}' WHERE comment_id = {$the_comment_id}";
                $update_to_unapproved_status = $connection->query($query);
                confirmQuery($update_to_unapproved_status);
                break;

            case 'delete':
                $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
                $delete_comment = $connection->query($query);
                confirmQuery($delete_comment);

                break;

        }
    }
}
}

    function usersOnline() {

        if(isset($_GET['onlineusers'])) {

        global $connection;

        if(!$connection) {

            session_start();

            include("../includes/db.php");

        $session = session_id();
        $time = time();
        $time_out_in_seconds = 10;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '{$session}'";
        $send_query = $connection->query($query);
        $count = $send_query->num_rows;

        if($count == NULL) {
            $query = "INSERT INTO users_online(session, time) VALUES('{$session}', {$time})";
            $connection->query($query);

        } else {
            $query = "UPDATE users_online SET time = {$time} WHERE session = '{$session}'";
            $connection->query($query);
        }

        $query = "SELECT * FROM users_online WHERE time > {$time_out}";
        $users_online_query = $connection->query($query);
        echo $count_users = $users_online_query->num_rows;

        }

    } // GET REQUEST

    }

    usersOnline();



    function confirmQuery($result)
    {
        global $connection;
        
        if(!$result) {
            die("QUERY FAILED. " . $connection->error);
        }
    } 

	function insert_categories()
	{
		global $connection;

		if(isset($_POST["submit"])) {
            $cat_title = escape($_POST["cat_title"]);
            if($cat_title == "" | empty($cat_title))
                echo "This field should not be empty";
            else {
                $query = "INSERT INTO categories(cat_title)";
                $query .= "VALUES(?)";
                $stmt = $connection->prepare($query);
                if(!$stmt)
                    die("QUERY FAILED".$connection->error);

                $stmt->bind_param("s", $cat_title);
                $stmt->execute();

                $stmt->close();
            }
        }
	}


	function findAllCategories() {
		global $connection;


		$query = "SELECT * FROM categories";
        $select_all_categories = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_all_categories)) {

            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];

            echo "<tr>";
            echo "<td>{$cat_id}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
            echo "<td><a onClick=\" javascript: return confirm('Are you sure you want to delete?') \"  href='categories.php?delete={$cat_id}'>Delete</a></td>";
            echo "</tr>";
        }

        

        
	}

	function deleteCategories()
	{
		global $connection;
		if(isset($_GET["delete"])) {
            $delete_id = escape($_GET["delete"]);
            $query = "DELETE FROM categories WHERE cat_id = {$delete_id}";
            $connection->query($query);
            header("Location: categories.php");
        }
	}

    function recordCount($table) {

        global $connection;

        $query = "SELECT * FROM " . $table;
        $select_all_query = $connection->query($query);
        confirmQuery($select_all_query);

        return $select_all_query->num_rows;
    }

    function userRecordCount($table, $user) {

        global $connection;

        if($table === 'posts') {

            $query = "SELECT * FROM posts WHERE post_user = '{$user}'";

        } else if($table === 'comments') {

            $query = "SELECT * FROM comments WHERE comments.comment_post_id IN (SELECT posts.post_id FROM posts WHERE posts.post_user = '{$user}')";
        }

        $select_all_query = $connection->query($query);
        confirmQuery($select_all_query);

        return $select_all_query->num_rows;
    }

    function checkStatus($table, $column, $status) {

        global $connection;

        $query = "SELECT * FROM $table WHERE $column = '$status'";
        confirmQuery($query);
        
        $result = $connection->query($query);

        return $result->num_rows;


    }

    function userCheckStatus($table, $user, $column, $status) {

        global $connection;

        if($table === 'posts') {

            $query = "SELECT * FROM posts WHERE post_user = '{$user}' AND $column = '$status'";

        } else if($table === 'comments') {

            $query = "SELECT * FROM comments WHERE $column = '$status' AND comments.comment_post_id IN (SELECT posts.post_id FROM posts WHERE posts.post_user = '{$user}')";
        }

        confirmQuery($query);
        
        $result = $connection->query($query);

        return $result->num_rows;


    }

    function is_admin($username) {

        global $connection;

        $query = "SELECT user_role FROM users WHERE username = '$username'";
        $result = $connection->query($query);

        confirmQuery($result);

        $row = $result->fetch_array();

        if($row['user_role'] == 'admin')
            return true;
        else
            return false;
    }

    function username_exists($username) {

        global $connection;

        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = $connection->query($query);

        confirmQuery($result);

        $row = $result->num_rows;

        if($row > 0)
            return true;
        else
            return false;
    }

    function email_exists($email) {

        global $connection;

        $query = "SELECT user_email FROM users WHERE user_email = '$email'";
        $result = $connection->query($query);

        confirmQuery($result);

        $row = $result->num_rows;

        if($row > 0)
            return true;
        else
            return false;
    }


    function register_user($user_firstname, $user_lastname, $username, $email, $password) {

        global $connection;

        $user_firstname = $connection->real_escape_string($user_firstname);
        $user_lastname = $connection->real_escape_string($user_lastname);
        $username = $connection->real_escape_string($username);
        $email = $connection->real_escape_string($email);
        $password = $connection->real_escape_string($password);

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));


        $query = "INSERT INTO users (user_firstname, user_lastname, username, user_email, user_password, user_role) ";
        $query .= "VALUES ('{$user_firstname}', '{$user_lastname}', '{$username}', '{$email}', '{$password}', 'subscriber')";
        $register_user_query = $connection->query($query);
        confirmQuery($register_user_query);

    }

    function login_user($username, $password) {

        global $connection;

        $username = trim($username);
        $password = trim($password);

        $username = $connection->real_escape_string($username);
        $password = $connection->real_escape_string($password);

        $query = "SELECT * FROM users WHERE username = '{$username}'";

        $select_user_query = $connection->query($query);
        if(!$select_user_query) {
            die("QUERY FAILED ".$connection->error);
        }

        while($row = $select_user_query->fetch_assoc()) {
            
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];


        if(password_verify($password, $db_user_password)) {

            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;

            if($db_user_role === 'admin')
                redirect("/cms/admin");
            else if($db_user_role === 'subscriber')
                redirect("/cms/user");
            else
                redirect("/cms");
        }

        else {

            return false;
        }

    }

}

 ?>