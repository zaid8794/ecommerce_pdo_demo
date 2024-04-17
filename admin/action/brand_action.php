<?php
require_once "../../class/Crud.php";
$obj = new Crud();
if ($_POST['form_type'] == 'save') {
    if (empty($_POST['category_name'])) {
        $data['msg_error'] = "Please select category name";
        $data['status'] = 0;
    } else if (empty($_POST['brand_name'])) {
        $data['msg_error'] = "Brand name is required";
        $data['status'] = 0;
    } else {
        $data  = [
            'brand_name' => $_POST['brand_name'],
            'brand_slug_url' => $obj->slugify($_POST['brand_name'], 'brand_slug_url', 'brand'),
            'brand_category_id' => $_POST['category_name'],
            'brand_created_at' => date('Y-m-d H:i:s'),
        ];
        $exec =  $obj->insert('brand', $data);
        if ($exec == 1) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
    }
    echo json_encode($data);
}

if ($_POST['form_type'] == 'edit') {
    $brand_id = $_POST['brand_id'];
    $query = $obj->custom_get('brand', "WHERE `brand_id` = '$brand_id'");
    echo json_encode($query);
}

if ($_POST['form_type'] == 'update_brand') {
    if (empty($_POST['category_name'])) {
        $data['msg_error'] = "Please select category name";
        $data['status'] = 0;
    } else if (empty($_POST['brand_name'])) {
        $data['msg_error'] = "Brand name is required";
        $data['status'] = 0;
    } else {
        $data  = [
            'brand_name' => $_POST['brand_name'],
            'brand_slug_url' => $obj->slugify($_POST['brand_name'], 'brand_slug_url', 'brand'),
            'brand_category_id' => $_POST['category_name'],
            'brand_created_at' => date('Y-m-d H:i:s'),
        ];
        $update_query = $obj->update('brand', $data, "WHERE `brand_id` = '" . $_POST['brand_id'] . "'");
        if ($update_query) {
            $output = [
                'status' => 1,
                'message' => 'Brand updated successfully',
            ];
            echo json_encode($output);
        }
    }
}

if ($_POST['form_type'] == 'delete') {
    $brand_id = $_POST['brand_id'];
    $a = $obj->delete('brand', "WHERE `brand_id` = '$brand_id'");
    if ($a == true) {
        $data = [
            'status' => 200,
            'data' => 'brand_' . $brand_id,
            'message' => 'Brand deleted successfully',
        ];
        echo json_encode($data);
    } else {
        $data = [
            'status' => 203,
            'message' => 'Something went wrong',
        ];
    }
}
