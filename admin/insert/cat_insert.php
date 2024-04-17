<?php
require_once '../../class/Crud.php';
$obj = new Crud();
if ($_POST['form_type'] == "save") {
    if (empty($_POST['category_name'])) {
        $data['msg_error'] = "Category name is required";
        $data['status'] = 0;
    } else {
        $data  = [
            'category_name' => $_POST['category_name'],
            'category_slug_url' => $obj->slugify($_POST['category_name'], 'category_slug_url', 'category'),
        ];
        $exec =  $obj->insert('category', $data);
        if ($exec == 1) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        // if ($obj->insert('category', $data)) {
        //     $data['status'] = 1;
        // } else {
        //     $data['status'] = 0;
        // }
    }
    echo json_encode($data);
}
if ($_POST['form_type'] == "edit") {
    if (empty($_POST['category_name'])) {
        $data['msg_error'] = "Category name is required";
        $data['status'] = 0;
    } else {
        $data  = [
            'category_name' => $_POST['category_name'],
            'category_slug_url' => $obj->slugify($_POST['category_name'], 'category_slug_url', 'category'),
        ];
        $exec =  $obj->update('category', $data, " WHERE `category_id` = '" . $_POST['category_id'] . "'");
        if ($exec == 1) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        // if ($obj->insert('category', $data)) {
        //     $data['status'] = 1;
        // } else {
        //     $data['status'] = 0;
        // }
    }
    echo json_encode($data);
}
