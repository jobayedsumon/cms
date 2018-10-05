<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>


<?php 

    if(!isset($_GET['email']) && !isset($_GET['token'])) {

        redirect('index');
    }
    
    $query = "SELECT username, user_email, token FROM users WHERE token = ?";

    if($stmt = $connection->prepare($query)) {

        $stmt->bind_param("s", $_GET['token']);
        $stmt->execute();
        $stmt->bind_result($username, $user_email, $token);
        $stmt->fetch();
        $stmt->close();

        if(escape($_GET['token']) !== $token || escape($_GET['email']) !== $user_email) {

            redirect('index');
        }

        if(isset($_POST['password']) && isset($_POST['confirmPassword'])) {

            if($_POST['password'] === $_POST['confirmPassword']) {

                $password = escape($_POST['password']);

                $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

                $query = "UPDATE users SET token ='', user_password = '{$hashed_password}' WHERE user_email = ?";

                if($stmt = $connection->prepare($query)) {

                    $stmt->bind_param("s", escape($_GET['email']));
                    $stmt->execute();

                    if($stmt->affected_rows >= 1) {
                        
                        redirect('login');
                    }

                    $stmt->close();

                }

            }
        }




    }
    


 ?>





<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Reset Password</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                                <input id="password" name="password" placeholder="Enter new password" class="form-control"  type="password">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                                <input id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" class="form-control"  type="password">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input name="reset-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                                <h2>Password reseted</h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->
