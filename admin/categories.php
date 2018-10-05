<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

    <!-- Navigation -->
<?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                 <div class="col-lg-12">
                    <h1 class="page-header">
                    Welcome to Admin
                    <small><?php echo $_SESSION['username']; ?></small>
                    </h1>

            <div class="col-xs-6">

                <?php insert_categories(); ?>

            <form action="" method="post">
            <div class="form-group">
                <label>Add Category</label>
                <input type="text" name="cat_title" class="form-control">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Add Category">

            </form>

            <?php 
             if(isset($_GET['edit'])) {
                $cat_id = escape($_GET['edit']);
                include "includes/update_categories.php";
             }

            ?>

            </div>

            <div class="col-xs-6">
     
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Category Title</td>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php findAllCategories(); ?>

                        <?php deleteCategories(); ?>

                    </tbody>
                </table>

            </div>




            </div>
            </div>
            <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
<!-- /#wrapper -->

<?php include "includes/admin_footer.php"; ?>


