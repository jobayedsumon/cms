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

                    </div>
                </div>
                <!-- /.row -->



                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

<?php 

$user = $_SESSION['username'];

$post_count = userRecordCount('posts', $user);
echo "<div class='huge'>{$post_count}</div>";

?>


                  
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
<?php 

$comment_count = userRecordCount('comments', $user);
echo "<div class='huge'>{$comment_count}</div>";

?>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    
</div>
                <!-- /.row -->

<div class="row">

<?php 

$post_published_count = userCheckStatus('posts', $user, 'post_status', 'published');

$post_draft_count = userCheckStatus('posts', $user, 'post_status', 'draft');

$unapproved_comment_count = userCheckStatus('comments', $user, 'comment_status', 'unapproved');


     ?>
    
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],

          <?php 

            $elemet_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pending Comments'];
            $elemet_count = [$post_count, $post_published_count, $post_draft_count, $comment_count, $unapproved_comment_count];

            for($i = 0; $i < 5; $i++) {

                echo "['{$elemet_text[$i]}'" . ", " . "{$elemet_count[$i]}],";
            }


           ?>

          
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

    <div id="columnchart_material" style="width: '960px'; height: 500px;"></div>


</div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include "includes/admin_footer.php"; ?>


