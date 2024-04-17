<?php
require_once "../../class/Crud.php";
$obj = new Crud();
if ($_POST['action'] == 'edit') {
    $cat_id = $_POST['cat_id'];
    $a = $obj->custom_get('category', "WHERE `category_id` = '$cat_id'");
    foreach ($a as $row) {
        echo json_encode($row);
    }
}
if ($_POST['action'] == 'delete') {
    $cat_id = $_POST['cat_id'];
    $a = $obj->delete('category', "WHERE `category_id` = '$cat_id'");
    if ($a == true) {
        $data = [
            'status' => 200,
            'data' => 'category_' . $cat_id,
            'message' => 'Category deleted successfully',
        ];
    } else {
        $data = [
            'status' => 203,
            'message' => 'Something went wrong',
        ];
    }
    echo json_encode($data);
}

if ($_POST['action'] == 'fetch_brand') {
    $cat_id = $_POST['cat_id'];
    $query = $obj->custom_get("brand", "WHERE `brand_category_id` = '$cat_id'");
    $output = '<option value="0" selected disabled>Select Your Brand Name</option>';
    foreach ($query as $brand) {
        $output .= '<option value="' . $brand['brand_id'] . '">' . $brand['brand_name'] . '</option>';
    }
    echo $output;
}
