<?php require_once("../../resources/config.php");


if(isset($_GET['delete_slide_id'])) {


$query = query("DELETE FROM slides WHERE slide_id = " . escape_string($_GET['delete_slide_id']) . " ");
confirm($query);


set_message("Slider Deleted");
redirect("../../../public/admin/index.php?slides");



} else {

   redirect("../../../public/admin/index.php?slides");


}







 ?>