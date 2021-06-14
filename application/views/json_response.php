<?php

$new_data = $data;
$new_data->success = $data->success;
$new_data->successMsg = isset($data->successMsg) ? $data->successMsg : "";
$new_data->successPage = isset($data->successPage) ? $data->successPage : "";
$new_data->successTitle = isset($data->successTitle) ? $data->successTitle : "";
$new_data->errorPage = isset($data->errorPage) ? $data->errorPage : "";
$new_data->errorMsg = isset($data->errorMsg) ? $data->errorMsg : "";
$new_data->errorTitle = isset($data->errorTitle) ? $data->errorTitle : "";
$new_data->errorThrown = isset($data->errorThrown) ? $data->errorThrown : NULL;

header('Content-Type: application/json; charset=utf-8');
echo json_encode($new_data);
