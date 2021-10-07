<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>


<div class="container">
   <?php register_user();?>

    <form class="form-horizontal" action='' method="POST">
        <div class="col-sm-4 col-sm-offset-5">
        <h2 class="text-center bg-warning"><?php display_name(); ?></h2>
            <div id="legend">
                <legend class="">Register</legend>
            </div>
            
            <div class="form-group"><label for="">
                    username<input type="text" name="username" class="form-control"></label>
            </div>
            <div class="form-group"><label for="email">
                    Email<input type="email" name="email" class="form-control"></label>
            </div>
            <div class="form-group"><label for="password">
                    Password<input type="password" name="password" class="form-control"></label>
            </div>
            <div class="form-group"><label for="password">
                    Confirm Password<input type="confpassword" name="confpassword" class="form-control"></label>
            </div>
            
            <!-- Button -->
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary">
            </div>
        </div>
</div>

</form>

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