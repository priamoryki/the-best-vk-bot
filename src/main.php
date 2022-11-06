<?php

$data = json_decode(file_get_contents('php://input'));
$user_id = $data->object->user_id;
