<?php require_once("../resources/config.php"); ?>

<?php  include(TEMPLATE_FRONT . DS . "header.php") ?>
<!-- Page Content -->
<div class="container">

    <!-- Side Navigation -->

    <?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>

    <?php


    $query = query(" SELECT * FROM products WHERE product_id = " . escape_string($_GET['id']) . " ");
    confirm($query);

    while ($row = fetch_array($query)) :


    ?>


        <div class="col-md-9">

            <!--Row For Image and Short Description-->

            <div class="row">
            <?php  update_views()?>

                <div class="col-md-7">


                    <img class="img-responsive" style="height:400px" src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">


                </div>

                <div class="col-md-5">

                    <div class="thumbnail">


                        <div class="caption-full">
                            <h4><a href="#"><?php echo $row['product_title']; ?></a> </h4>
                            <hr>
                            <h4 class=""><?php echo "&#36;" . $row['product_price']; ?></h4>

                            <div class="ratings">

                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                    4.0 stars
                                </p>
                            </div>

                            <p><?php echo $row['short_desc']; ?></p>


                            <form action="">
                                <div class="form-group">
                                    <a href="../resources/cart.php?add=<?php echo $row['product_id']; ?>" class="btn btn-primary">ADD</a>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>


            </div>
            <!--Row For Image and Short Description-->


            <hr>


            <!--Row for Tab Panel-->

            <div class="row">

                <div role="tabpanel">


                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>
                        <li role="presentation"><a href="#product" aria-controls="product" role="tab" data-toggle="tab">San pham lien quan</a></li>

                    </ul>


                    <div class="tab-content">
                        <!-- <div role="tabpanel" class="tab-pane " id="role">

                            <p>Ban phai dang nhap tai khoan truoc khi binh luan</p>

                        </div> -->
                        <div role="tabpanel" class="tab-pane active" id="home">

                            <p></p>

                            <p><?php echo $row['product_description']; ?></p>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">

                            <div class="col-md-6">
                                <?php count_review(); ?>

                                <hr>

                                 <div class="row">

                                 <?php review_product(); ?>
                                

                                    
                                </div>





                            </div>

                            <?php add_review(); ?>
                            <div class="col-md-6">
                                <h3>Add A review</h3>
                                
                                <form action="" class="form-inline" method="POST">

                                

                                    <div>
                                        <h3>Your Rating</h3>
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star"></span>
                                    </div>

                                    <br>
                                    <input type="hidden" name="id" value="<?= $_GET['id']?>">
                                    <div class="form-group">
                                        <textarea name="comment" id="" cols="60" rows="10" class="form-control"></textarea>
                                    </div>

                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <button type="submit" name="add_review" class="btn btn-primary" value="">Submit</button>
                                    </div>
                                   


                                </form>

                            </div>
                            
                        </div>

                        <div role="tabpanel" class="tab-pane" id="product">
                            <div class="col-md-6">


                                    <?php product_info($row['product_category_id']); ?>
                            </div>
                        </div>
                        

                    </div>

                </div>


            </div>
         




        </div>


    <?php endwhile; ?>

</div>


<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>