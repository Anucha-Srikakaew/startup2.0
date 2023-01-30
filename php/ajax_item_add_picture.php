<?php
$name = $_POST['name'];
$img = $_POST['img'];

$img = str_replace("data:image/png;base64,", "", $img);
$img = str_replace("data:image/jpeg;base64,", "", $img);

$url = 'http://43.72.52.239/STARTUP_photo_body/photo_By_item/uploadphoto.php';
$data = array(
    'name' => $name,
    'img' => $img
);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    )
);

$context  = stream_context_create($options);

$result = file_get_contents($url, false, $context);

echo json_encode($result);
