<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With");




$response = array();
$upload_dir = 'uploads/';
$server_url = 'http://127.0.0.1:8000';

if($_FILES['file'])
{
  $file_name = $_FILES["file"]["name"];
  $file_tmp_name = $_FILES["file"]["tmp_name"];
  $error = $_FILES["file"]["error"];

  if($error > 0){
    $response = array(
      "status" => "error",
      "error" => true,
      "message" => "Error uploading the file!"
    );
  }else
  {
    $random_name = rand(1000,1000000)."-".$file_name;
    $upload_name = $upload_dir.strtolower($random_name);
    $upload_name = preg_replace('/\s+/', '-', $upload_name);

    if(move_uploaded_file($file_tmp_name , $upload_name)) {
      $response = array(
        "status" => "success",
        "error" => false,
        "message" => "File uploaded successfully",
        "url" => $server_url."/".$upload_name
      );
    }else
    {
      $response = array(
        "status" => "error",
        "error" => true,
        "message" => "Error uploading the file!"
      );
    }
  }





}else{
  $response = array(
    "status" => "error",
    "error" => true,
    "message" => "No file was sent!"
  );
}

echo json_encode($response);
?>
