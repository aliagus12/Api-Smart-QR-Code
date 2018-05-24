<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 23/05/18
 * Time: 16.48
 */
define('ROOT', '../../');
if (isset($_GET['email'])) {
    include_once  ROOT. 'data/read/read_one.php';
} else {
    include_once ROOT. 'data/read/read_all.php';
}