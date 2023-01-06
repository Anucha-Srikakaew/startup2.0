<?php
session_start();
session_destroy();
$result = array('success');
echo json_encode($result);
