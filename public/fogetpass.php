<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<!-- Page Content -->
<div class="container">

  <header>
    <h1 class="text-center">Reset Password</h1>
    <h2 class="text-center bg-warning"><?php display_name(); ?></h2>
        <div class="col-sm-4 col-sm-offset-5">         
            <form action="" method="post" enctype="multipart/form-data">
            <?php fogot_password(); ?>
            
                <div class="form-group"><label for="">
                    username<input type="text" name="username" class="form-control"></label>
                </div>
                 <div class="form-group"><label for="password">
                    Email<input type="email" name="email" class="form-control"></label>
                </div>
                
                
                <div class="form-group">
                  <input type="submit" name="submit" class="btn btn-primary" >
                </div>
              
               
            </form>
        </div>  



  </header>


</div>

</div>
<!-- /.container -->

<div class="container">

  <hr>

  <!-- Footer -->
  <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>