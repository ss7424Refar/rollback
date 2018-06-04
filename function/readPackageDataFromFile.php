<?php
/**
 * Created by PhpStorm.
 * User: refar
 * Date: 18-6-2
 * Time: 下午5:32
 */

$file_path = "../resource/packageDetail.txt";
$new_array = array();
if (file_exists($file_path)) {
    $file_arr = file($file_path);
//    echo count($file_arr);
    for ($i = 0; $i < count($file_arr); $i++) {//逐行读取文件内容
        array_push($new_array, explode("=",rtrim($file_arr[$i],"\n"))) ;
    }
    echo json_encode($new_array);
} else {
    echo json_encode("ng");
}

