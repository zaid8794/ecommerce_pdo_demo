<?php
require_once "../../class/Crud.php";
$obj = new Crud();
if ($_POST['form_type'] == 'save') {
    $result = [];
    $allowed_types = ['jpg', 'png', 'bmp', 'jpeg'];
    $max_file_size = 5 * 1024 * 1024;
    if ($_FILES['product_thumbnail']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['product_thumbnail']['name'];
        $tmp_file_name = $_FILES['product_thumbnail']['tmp_name'];
        $file_etension_name = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_size = $_FILES['product_thumbnail']['size'];
        if (!in_array($file_etension_name, $allowed_types)) {
            $result = [
                'status' => "error",
                'message' => "Invalid file extension",
            ];
        } elseif ($file_size > $max_file_size) {
            $result = [
                'status' => "error",
                'message' => "Invalid file size, max file size is 5MB",
            ];
        } else {
            $new_file_name = date("Ymdhis") . '.' . $file_etension_name;
            $target_dir = "../../uploads/products/";
            $target_file = $target_dir . '/' . $new_file_name;
            move_uploaded_file($tmp_file_name, $target_file);
            if (empty($_POST['product_title'])) {
                $result['msg_error'] = "Product title is required";
                $result['status'] = 0;
            } else if (empty($_POST['category_name'])) {
                $result['msg_error'] = "Please select category name";
                $result['status'] = 0;
            } else if (empty($_POST['brand_name'])) {
                $result['msg_error'] = "Please select brand name";
                $result['status'] = 0;
            } else {
                $product_data  = [
                    'product_title' => $_POST['product_title'],
                    'category_id' => $_POST['category_name'],
                    'brand_id' => $_POST['brand_name'],
                    'regular_price' => $_POST['regular_price'],
                    'selling_price' => $_POST['selling_price'],
                    'short_description' => $_POST['short_description'],
                    'long_description' => $_POST['long_description'],
                    'status' => 1,
                    'created_at' => date("Y-m-d H:i:s"),
                ];
                if ($file_name) {
                    $product_data['product_thumbnail'] = $new_file_name;
                }
                $exec =  $obj->insert('products', $product_data);
                if ($exec == 1) {
                    $result['status'] = 1;
                } else {
                    $result['status'] = 0;
                }
            }
        }
    } else {
        $result = [
            'status' => "error",
            'message' => "Error uploading file",
        ];
    }
    echo json_encode($result);
}
