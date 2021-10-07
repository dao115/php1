<?php require_once("../../resources/config.php");


if (isset($_GET['delete_comment_id'])) {


    $query = query("DELETE FROM comments WHERE ma_bl = " . escape_string($_GET['delete_comment_id']) . " ");

    confirm($query);


    set_message("commets Deleted");
    redirect("./index.php?comments");
} else {

    redirect("./index.php?comments");
}
