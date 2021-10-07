<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<div class="container">
<section class="mb-5 text-center">

<div id="legend">
                <legend class="">Cap nhat tai khoan</legend>
</div>
<h2 class="text-center bg-warning"><?php display_name(); ?></h2>

  <form action="" method="POST">
  <?php 
      $_userId = $_SESSION['user']['user_id'];
      
      
      
      update_user($_userId); ?>

      <div class="form-group"><label for="">
               Username<input type="text" name="username" class="form-control"></label>
    </div>
    <div class="form-group"><label for="">
               Email<input type="email" name="email" class="form-control"></label>
    </div>
   
   

    

    <button type="submit" name="submit" class="btn btn-primary mb-4">Cap Nhat</button>

  </form>

  <div class="d-flex justify-content-between align-items-center mb-2">

    <u><a href="login.php">Back to Log In</a></u>

    <u><a href="register.php">Register</a></u>

  </div>

</section>
</div>
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
<!--Section: Block Content-->