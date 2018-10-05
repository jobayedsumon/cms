<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>


<?php 

$msg = "";

if(isset($_POST['submit'])) {

    $to = "sumonjobayed@gmail.com";
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $header = "From: ".$email;

    if(mail($to, $subject, $message, $header)) {
        $msg = "SENT";
    } else {
        $msg = "NOT SENT";
    }



}

 ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                        <h6><?php echo $msg; ?></h6>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject">
                        </div>
                        <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="10" cols="50"></textarea>
                        </div>
                         
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
