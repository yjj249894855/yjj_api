<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$aawwd = date("Y/m/d H:i:s");
            //$aa = 44;
            var_dump($aawwd);

 try {
$aa = 44;
var_dump($aa);
//var_dump($aaw);
        } catch (\Exception $e) {
            echo $e->getMessage();
//            report($e);
//            Log::error($e->getMessage());
            //throw EmployeeException::error(2000104);
        }