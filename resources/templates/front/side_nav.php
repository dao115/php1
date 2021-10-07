<div class="col-md-3">
    <p class="lead">Xshop</p>
    <?php search(); ?>
   

    <br>
    <div class="list-group">

        <?php
        get_categories();


        ?>

    </div>
    <br>
    
    <div class="list-group">
    <h4>Top 10 </h4>

        <?php
       
       get_product_select_top10();

        ?>

    </div>
</div>