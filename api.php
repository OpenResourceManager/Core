<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/5/15
 * Time: 12:46 PM
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once dirname(__FILE__) . '/lib/api/API.php';

$api = new API();

if (isset($_POST['X-Authorization'])) {
    if ($api->checkAPIKey($_POST['X-Authorization'])) {

    } else {
        $api->unauthorized();
    }
} else {
    $api->unauthorized();
}
