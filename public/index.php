<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<?php

//  if (isset($_SESSION['role']) == 0){
//      $_SESSION['role'] = 2;}

// ?>

<body>

    <!-- Navigation -->

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                    <?php include(TEMPLATE_FRONT . DS . "slider.php") ?>
                    </div>

                </div>

                <div class="row">
                   
                    <?php
                    if (isset($_GET['search'])) {
                     get_products_select_by_search();

                    }else{
                        get_products_with_pagination(3);
                    }
                    
                    
                    ?>




                </div>

            </div>

        </div>

    </div>
     <?php include(TEMPLATE_FRONT . DS . "footer.php") ?> 
  

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>


</html>