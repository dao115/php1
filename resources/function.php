<?php



$upload_directory = "uploads";

// helper functions


function last_id()
{

    global $connection;

    return mysqli_insert_id($connection);
}


function set_message($msg)
{

    if (!empty($msg)) {

        $_SESSION['message'] = $msg;
    } else {

        $msg = "";
    }
}


function display_name()
{

    if (isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}


function redirect($location)
{

    return header("Location: $location ");
}



// function redirect($location, $sec=0)
// {
//     if (!headers_sent())
//     {
//         header( "refresh: $sec;url=$location" ); 
//     }
//     elseif (headers_sent())
//     {
//         echo '<noscript>';
//         echo '<meta http-equiv="refresh" content="'.$sec.';url='.$location.'" />';
//         echo '</noscript>';
//     }
//     else
//     {
//         echo '<script type="text/javascript">';
//         echo 'window.location.href="'.$location.'";';
//         echo '</script>';
//     }
// }



function query($sql)
{

    global $connection;

    return mysqli_query($connection, $sql);
}


function confirm($result)
{

    global $connection;

    if (!$result) {

        die("QUERY FAILED " . mysqli_error($connection));
    }
}


function escape_string($string)
{

    global $connection;

    return mysqli_real_escape_string($connection, $string);
}



function fetch_array($result)
{

    return mysqli_fetch_array($result);
}


/****************************FRONT END FUNCTIONS************************/


// get products 


//function get_products() {
//$query = query(" SELECT * FROM products");
//confirm($query);
//while($row = fetch_array($query)) {
//$product_image = display_image($row['product_image']);
//$product = <<<DELIMETER
//<div class="col-sm-4 col-lg-4 col-md-4">
//    <div class="thumbnail">
//        <a href="item.php?id={$row['product_id']}"><img style="height: 90px" src="../resources/{$product_image}" alt=""></a>
//        <div class="caption">
//            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
//            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
//            </h4>
//            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
//             <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
//        </div>
//    </div>
//</div>
//DELIMETER;
//echo $product;
//		}
//}

function count_all_records($table)
{
    return mysqli_num_rows(query('SELECT * FROM ' . $table));
}

function count_all_products_in_stock()
{

    return mysqli_num_rows(query('SELECT * FROM products WHERE product_quantity >= 1'));
}


function get_products_select_by_search()
{
    if (isset($_GET['search'])) {
        $_search = $_GET['search'];
    }

    $query = query("SELECT * FROM products where product_title like '%" . $_search . "%'");


    confirm($query);
    while ($row = fetch_array($query)) {

        $product_image = display_image($row['product_image']);

        $product = <<<DELIMETER


        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="item.php?id={$row['product_id']}"><img style="height: 400px" src="../resources/{$product_image}" alt=""></a>
                <div class="caption">
                    <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                    <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                    </h4>
                    <p>{$row['product_description']}</p>
                     <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
                </div>
            </div>
        </div>
        DELIMETER;
    }


    echo $product;
}

function get_products_with_pagination($perPage = "6")
{
    $rows = count_all_products_in_stock();


    if (isset($_GET['page'])) { //get page from URL if its there
        $page = preg_replace('#[^0-9]#', '', $_GET['page']); //filter everything but numbers



    } else {
        $page = 1;
    }



    $lastPage = ceil($rows / $perPage);

    if ($page < 1) {
        $page = 1;
    } elseif ($page > $lastPage) {
        $page = $lastPage;
    }

    $middleNumbers = '';
    $sub1 = $page - 1;
    $sub2 = $page - 2;
    $add1 = $page + 1;
    $add2 = $page + 2;
    if ($page == 1) {
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';
    } elseif ($page == $lastPage) {
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
    } elseif ($page > 2 && $page < ($lastPage - 1)) {
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub2 . '">' . $sub2 . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add2 . '">' . $add2 . '</a></li>';
    } elseif ($page > 1 && $page < $lastPage) {
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page= ' . $sub1 . '">' . $sub1 . '</a></li>';
        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
        $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';
    }

    $limit = 'LIMIT ' . ($page - 1) * $perPage . ',' . $perPage;
    $query2 = query(" SELECT * FROM products WHERE product_quantity >= 1 " . $limit);
    confirm($query2);
    $outputPagination = ""; // Initialize the pagination output variable

    if ($page != 1) {
        $prev  = $page - 1;
        $outputPagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $prev . '">Back</a></li>';
    }

    $outputPagination .= $middleNumbers;

    if ($page != $lastPage) {
        $next = $page + 1;
        $outputPagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $next . '">Next</a></li>';
    }

    while ($row = fetch_array($query2)) {
        $product_image = display_image($row['product_image']);
        $product = <<<DELIMETER

            <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">
                    <a href="item.php?id={$row['product_id']}"><img style="height:400px" src="../resources/{$product_image}" alt=""></a>
                    <div class="caption">
                        <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                       
                        <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                        </h4>
                        <p>{$row['product_description']}</p>
                        <p class="text-center"><a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
                        </a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a></p>
                    </div>
                </div>
            </div>

DELIMETER;
        echo $product;
    }

    echo "<div class='text-center' style='clear: both;' ><ul class='pagination' >{$outputPagination}</ul></div>";
}








function get_categories()
{


    $query = query("SELECT * FROM categories");
    confirm($query);

    while ($row = fetch_array($query)) {


        $categories_links = <<<DELIMETER

        <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>


DELIMETER;

        echo $categories_links;
    }
}





function get_products_in_cat_page()
{


    $query = query(" SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " AND product_quantity >= 1 ");
    confirm($query);

    while ($row = fetch_array($query)) {

        $product_image = display_image($row['product_image']);

        $product = <<<DELIMETER


            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img style="height:400px" src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;

        echo $product;
    }
}







function get_products_in_shop_page()
{


    $query = query(" SELECT * FROM products WHERE product_quantity >= 1 ");
    confirm($query);

    while ($row = fetch_array($query)) {

        $product_image = display_image($row['product_image']);

        $product = <<<DELIMETER


            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img width="300px" src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;

        echo $product;
    }
}



function login_user()
{

    if (isset($_POST['submit'])) {

        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        confirm($query);
        $row = fetch_array($query);

        if (mysqli_num_rows($query) == 0) {

            set_message("Your Password or Username are wrong");
            redirect("login.php");
        } else {

            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            
            $_SESSION['user'] = $row;

            if ($row['role'] == 1) {
                redirect("admin");
            } else {
                header("location:index.php");
            }
        }
    }
}



function send_message()
{

    if (isset($_POST['submit'])) {

        $to          = "someEmailaddress@gmail.com";
        $from_name   =   $_POST['name'];
        $subject     =   $_POST['subject'];
        $email       =   $_POST['email'];
        $message     =   $_POST['message'];


        $headers = "From: {$from_name} {$email}";


        $result = mail($to, $subject, $message, $headers);

        if (!$result) {

            set_message("Sorry we could not send your message");
            redirect("contact.php");
        } else {

            set_message("Your Message has been sent");
            redirect("contact.php");
        }
    }
}



/****************************BACK END FUNCTIONS************************/


function display_orders()
{



    $query = query("SELECT * FROM orders");
    confirm($query);


    while ($row = fetch_array($query)) {


        $orders = <<<DELIMETER

<tr>
    <td>{$row['order_id']}</td>
    <td>{$row['order_amount']}</td>
    <td>{$row['order_transaction']}</td>
    <td>{$row['order_currency']}</td>
    <td>{$row['order_status']}</td>
    <td><a class="btn btn-danger" href="index.php?delete_order_id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>




DELIMETER;

        echo $orders;
    }
}




/************************ Admin Products Page ********************/

function display_image($picture)
{

    global $upload_directory;

    return $upload_directory  . DS . $picture;
}





function get_products_in_admin()
{


    $query = query(" SELECT * FROM products");
    confirm($query);

    while ($row = fetch_array($query)) {

        $category = show_product_category_title($row['product_category_id']);

        $product_image = display_image($row['product_image']);

        $product = <<<DELIMETER

        <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br>
        <a href="index.php?edit_product&id={$row['product_id']}"><img width='100' src="../../resources/{$product_image}" alt=""></a>
            </td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
             <td><a class="btn btn-danger" href="index.php?delete_product_id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;

        echo $product;
    }
}


function show_product_category_title($product_category_id)
{


    $category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}' ");
    confirm($category_query);

    while ($category_row = fetch_array($category_query)) {

        return $category_row['cat_title'];
    }
}






/***************************Add Products in admin********************/


function add_product()
{


    if (isset($_POST['publish'])) {


        $product_title          = escape_string($_POST['product_title']);
        $product_category_id    = escape_string($_POST['product_category_id']);
        $product_price          = escape_string($_POST['product_price']);
        $product_description    = escape_string($_POST['product_description']);
        $short_desc             = escape_string($_POST['short_desc']);
        $product_quantity       = escape_string($_POST['product_quantity']);
        $product_image          = $_FILES['file']['name'];
        $image_temp_location    = $_FILES['file']['tmp_name'];

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);


        $query = query("INSERT INTO products(product_title, product_category_id, product_price, product_description, short_desc, product_quantity, product_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$short_desc}', '{$product_quantity}', '{$product_image}')");
        $last_id = last_id();
        confirm($query);
        set_message("New Product with id {$last_id} was Added");
        redirect("index.php?products");
    }
}

function show_categories_add_product_page()
{


    $query = query("SELECT * FROM categories");
    confirm($query);

    while ($row = fetch_array($query)) {


        $categories_options = <<<DELIMETER

 <option value="{$row['cat_id']}">{$row['cat_title']}</option>


DELIMETER;

        echo $categories_options;
    }
}



/***************************updating product code ***********************/

function update_product()
{


    if (isset($_POST['update'])) {


        $product_title          = escape_string($_POST['product_title']);
        $product_category_id    = escape_string($_POST['product_category_id']);
        $product_price          = escape_string($_POST['product_price']);
        $product_description    = escape_string($_POST['product_description']);
        $short_desc             = escape_string($_POST['short_desc']);
        $product_quantity       = escape_string($_POST['product_quantity']);
        $product_image          = escape_string($_FILES['file']['name']);
        $image_temp_location    = escape_string($_FILES['file']['tmp_name']);


        if (empty($product_image)) {

            $get_pic = query("SELECT product_image FROM products WHERE product_id =" . escape_string($_GET['id']) . " ");
            confirm($get_pic);

            while ($pic = fetch_array($get_pic)) {

                $product_image = $pic['product_image'];
            }
        }



        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);


        $query = "UPDATE products SET ";
        $query .= "product_title            = '{$product_title}'        , ";
        $query .= "product_category_id      = '{$product_category_id}'  , ";
        $query .= "product_price            = '{$product_price}'        , ";
        $query .= "product_description      = '{$product_description}'  , ";
        $query .= "short_desc               = '{$short_desc}'           , ";
        $query .= "product_quantity         = '{$product_quantity}'     , ";
        $query .= "product_image            = '{$product_image}'          ";
        $query .= "WHERE product_id=" . escape_string($_GET['id']);





        $send_update_query = query($query);
        confirm($send_update_query);
        set_message("Product has been updated");
        redirect("index.php?products");
    }
}

/*************************Categories in admin ********************/


function show_categories_in_admin()
{


    $category_query = query("SELECT * FROM categories");
    confirm($category_query);


    while ($row = fetch_array($category_query)) {

        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];


        $category = <<<DELIMETER


<tr>
    <td>{$cat_id}</td>
    <td>{$cat_title}</td>
    <td><a class="btn btn-danger" href="./index.php?delete_category_id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>



DELIMETER;

        echo $category;
    }
}


function add_category()
{

    if (isset($_POST['add_category'])) {
        $cat_title = escape_string($_POST['cat_title']);

        if (empty($cat_title) || $cat_title == " ") {

            echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
        } else {


            $insert_cat = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}') ");
            confirm($insert_cat);
            set_message("Category Created");
        }
    }
}

/************************admin users***********************/



function display_users()
{


    $category_query = query("SELECT * FROM users");
    confirm($category_query);


    while ($row = fetch_array($category_query)) {

        $user_id = $row['user_id'];
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];

        $user = <<<DELIMETER


<tr>
    <td>{$user_id}</td>
    <td>{$username}</td>
     <td>{$email}</td>
    <td><a class="btn btn-danger" href="index.php?delete_user_id={$row['user_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>



DELIMETER;

        echo $user;
    }
}


function add_user()
{


    if (isset($_POST['add_user'])) {


        $username   = escape_string($_POST['username']);
        $email      = escape_string($_POST['email']);
        $password   = escape_string($_POST['password']);
       


        $query = query("INSERT INTO users(username,email,password) VALUES('{$username}','{$email}','{$password}')");
        confirm($query);

        set_message("USER CREATED");

        redirect("index.php?users");
    }
}





function get_reports()
{


    $query = query(" SELECT * FROM reports");
    confirm($query);

    while ($row = fetch_array($query)) {


        $report = <<<DELIMETER

        <tr>
             <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_title']}
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="./index.php?delete_report_id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;

        echo $report;
    }
}


//////// SLIDES ////////

function add_slides()
{

    if (isset($_POST['add_slide'])) {


        $slide_title        = escape_string($_POST['slide_title']);
        $slide_image        = $_FILES['file']['name'];
        $slide_image_loc    = $_FILES['file']['tmp_name'];


        if (empty($slide_title) || empty($slide_image)) {

            echo "<p class='bg-danger'>This field cannot be empty</p>";
        } else {



            move_uploaded_file($slide_image_loc, UPLOAD_DIRECTORY . DS . $slide_image);

            $query = query("INSERT INTO slides(slide_title, slide_image) VALUES('{$slide_title}', '{$slide_image}')");
            confirm($query);
            set_message("Slide Added");
            redirect("index.php?slides");
        }
    }
}
function get_current_slide()
{
}

function get_current_slide_in_admin()
{

    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);

    while ($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

        $slide_active_admin = <<<DELIMETER



    <img class="img-responsive" src="../../resources/{$slide_image}" alt="">



DELIMETER;

        echo $slide_active_admin;
    }
}


function get_active_slide()
{
    $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
    confirm($query);



    while ($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

        $slide_active = <<<DELIMETER


 <div class="item active">
    <img class="slide-image" src="../resources/{$slide_image}" alt="">
</div>


DELIMETER;

        echo $slide_active;
    }
}

function get_slides()
{

    $query = query("SELECT * FROM slides");
    confirm($query);

    while ($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

        $slides = <<<DELIMETER
 <div class="item">
    <img class="slide-image" src="../resources/{$slide_image}" alt="">
</div>
DELIMETER;

        echo $slides;
    }
}
function get_slide_thumbnails()
{

    $query = query("SELECT * FROM slides ORDER BY slide_id ASC ");
    confirm($query);

    while ($row = fetch_array($query)) {

        $slide_image = display_image($row['slide_image']);

        $slide_thumb_admin = <<<DELIMETER


<div class="col-xs-6 col-md-3 image_container">
    
    <a href="index.php?delete_slide_id={$row['slide_id']}">
        
         <img  width='300' class="img-responsive slide_image" src="../../resources/{$slide_image}" alt="">


    </a>

    <div class="caption">

    <p>{$row['slide_title']}</p>

    </div>


</div>


    



DELIMETER;

        echo $slide_thumb_admin;
    }
}


function search()
{



    $search = <<<DELIMETER
        <form class="form-inline d-flex justify-content-center md-form form-sm mt-0">
        
        <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search" aria-label="Search" name="search" >
        </form>
            
DELIMETER;
    echo $search;
}


function get_product_select_top10()
{


    $query = query("SELECT * FROM products WHERE views > 0 ORDER BY views DESC LIMIT 10 ");
    confirm($query);

    while ($row = fetch_array($query)) {

        

        $top10_links = <<<DELIMETER
        
       
        <a href='item.php?id={$row['product_id']}' class='list-group-item'>{$row['product_title']}</a>
       
       
       
    
        


DELIMETER;

        echo $top10_links;
    }
}
function review_product()
{
    $id = $_GET['id'];
    $query = query("SELECT * FROM comments inner join users on comments.ma_user = users.user_id where ma_product = $id");
    confirm($query);

    while ($row = fetch_array($query)) {
        $review = display_image($row['user_image']);

        $review_products = <<<DELIMETER

        <img  width='300' class="img-responsive slide_image" src="../../resources/{$review}" alt="anh">
        <div class="col-md-12">
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star-empty"></span>
        
        <span class="pull-right">{$row['username']}</span>
        <p>{$row['contents']}</p>

        <button type="button" class="btn btn-danger"><a href="./item.php?delete_comments={$row['ma_bl']}">Xoa</a></button>
        </div>
       





     
       

DELIMETER;

        echo $review_products;
    }
}
function count_review()
{
    $id = $_GET['id'];
    $query = query("SELECT count(*) as SL FROM comments where ma_product = $id ");
    confirm($query);

    while ($row = fetch_array($query)) {


        $count_review = <<<DELIMETER

         
       <h3>{$row['SL']}_Reviews Product </h3>


DELIMETER;

        echo $count_review;
    }
}
function add_review()
{
    // var_dump($_POST['add_review']);
    if (isset($_POST['add_review'])) {
        
        $comment_title = $_POST['comment'];
        $comment_product = $_POST['id'];
        $comment_user = $_SESSION['user']['user_id'];

        
        $insert_comment = query("INSERT INTO comments(ma_user, ma_product, contents)
        VALUES('$comment_user', '$comment_product', '$comment_title ')");
        
        confirm($insert_comment);
        
        set_message("Created");  
        

        
        






    }
}

function show_comments()
{

    $query = query(" SELECT * FROM comments");
    confirm($query);

    while ($row = fetch_array($query)) {





        $comment = <<<DELIMETER

        <tr>
            <td>{$row['ma_bl']}</td>
            <td>{$row['ma_user']}<br>
           
            <td>{$row['ma_product']}</td>
            <td>{$row['contents']}</td>
 
            <td><a class="btn btn-danger" href="index.php?delete_comment_id={$row['ma_bl']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

DELIMETER;

        echo $comment;
    }
}
function register_user()
{
    if (isset($_POST['submit'])) {


        $username = escape_string($_POST['username']);
        $email = escape_string($_POST['email']);
        $password = escape_string($_POST['password']);
        $confirmPassword = escape_string($_POST['confpassword']);

        if (
            empty($username) || $username == " " && empty($email) || $email == " "
            && empty($password) || $password == " "
        ) {

            echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
        } elseif ($password != $confirmPassword) {
            echo "<p class='bg-danger'> PASSWORD NOT MATCH</p>";
        } else {


            $query = query("INSERT INTO users(username, email, password) 
            VALUES('{$username}', '{$email}', '{$password}')");
            confirm($query);
            set_message("Dang ky tai khoan thanh cong!");
        }
    }
}
function update_views(){
    $id = $_GET['id'];
    $query = query("UPDATE products SET views = views + 1 where product_id = $id ");
    confirm($query);
}
function count_product(){

    
    $query = query("SELECT count(*) as SL FROM products");
    confirm($query);

    while ($row = fetch_array($query)) {


        $count_review = <<<DELIMETER

         
       <h3>{$row['SL']} products</h3>

       DELIMETER;
       echo $count_review;

}
}

function count_category(){

    
        $query = query("SELECT count(*) as SL FROM categories");
        confirm($query);
    
        while ($row = fetch_array($query)) {
    
    
            $count_review = <<<DELIMETER
    
             
           <h3>{$row['SL']} Category</h3>
    
           DELIMETER;
           echo $count_review;
    
    }
}

function view_user(){

    
    $query = query("SELECT count(*) as SL FROM users");
    confirm($query);

    while ($row = fetch_array($query)) {


        $count_review = <<<DELIMETER

         
       <h3>{$row['SL']} Users</h3>

       DELIMETER;
       echo $count_review;

}
}
function change_paswrod($id){


    

    if (isset($_POST['submit'])) {
       
        $oldPassword = escape_string($_POST['oldpassword']);
        $newPassword = escape_string($_POST['newpassword']);
        $confirmPasswrod = escape_string($_POST['confirmpass']);
       

        if (
            empty($newPassword) || $newPassword == " " && empty($confirmPasswrod) || $confirmPasswrod == " "
            &&  empty($oldPassword) || $oldPassword == " "
            
        ) {

            echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
        } elseif ($newPassword != $confirmPasswrod) {
            echo "<p class='bg-danger'> PASSWORD NOT MATCH</p>";
        } else {


            $query = query("UPDATE users SET password = $newPassword where user_id = $id ");    
            confirm($query);
            set_message("Thay doi mat khau thanh cong");
        }
    }

}
function fogot_password(){
    if (isset($_POST['submit'])) {
    $username = escape_string($_POST['username']);
    $email = escape_string($_POST['email']);

    if (
        empty($username) || $username == " " && empty($email) || $email == " "
        
        
    ) {

        echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
    }else{
        $query = query("SELECT * FROM users");
        confirm($query);
        // set_message("lay lai mk thanh cong");

        while ($row = fetch_array($query)) {

            if($row['username'] == $username && $row['email'] == $email){
                echo $row['password'];
                   

            }
           
           
            


            
        

    }
    

}
}
}


function product_info($cat_id){
    
    $query = query("SELECT * FROM products where product_category_id = $cat_id ");
    confirm($query);

    while ($row = fetch_array($query)) {


        $product_info = <<<DELIMETER
        

        <a href='item.php?id={$row['product_id']}' class='list-group-item'>{$row['product_title']}</a>


        DELIMETER;

        echo  $product_info;
    } 

}
function update_user($id){
    if (isset($_POST['submit'])) {
       
        $username = escape_string($_POST['username']);
        $email = escape_string($_POST['email']);
        
       

        if (
            empty($username) || $username == " " && empty($email) || $email == " "
           
            
        ) {

            echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
        }else {


            $query = query("UPDATE users SET username = '$username', email = '$email' where user_id = $id ");    
            confirm($query);
            set_message("Cap nhat thong tin thanh cong");
        }
    }


}

       