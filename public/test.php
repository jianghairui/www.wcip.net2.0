<?php
/**
 * Created by PhpStorm.
 * User: Jiang
 * Date: 2019/12/9
 * Time: 15:34
 */
define('APP_PATH',__DIR__);
define('ROOT_PATH',dirname(__DIR__));


header("Content-Type: application/json");
header('Access-Control-Allow-Origin:*');

die();

echo json_encode($_SERVER);


$log_file = 'none';

if($_SERVER['REMOTE_ADDR']) {
    $log_file = $_SERVER['REMOTE_ADDR'];
}




tlog('test.php',var_export($_SERVER,true),$log_file);







function tlog($cmd = '',$msg = '',$log_file) {
    $file= ROOT_PATH . '/'.$log_file.'.log';
    $text='[Time ' . date('Y-m-d H:i:s') ."]  cmd:".$cmd."\n".$msg."\n---END---" . "\n";
    if(false !== fopen($file,'a+')){
        file_put_contents($file,$text,FILE_APPEND);
    }else{
        echo '创建失败';
    }
}