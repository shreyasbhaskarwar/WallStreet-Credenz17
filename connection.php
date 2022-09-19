<?php
/**
 * Created by PhpStorm.
 * User: Rama
 * Date: 9/6/2017
 * Time: 6:03 AM
 */
require_once ("config.php");
try{

    $conn=new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

}
catch (PDOException $exception)
{
    echo "Error".$exception->getMessage();
}
