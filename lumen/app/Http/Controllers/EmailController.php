<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:46 PM
 */

ini_set('error_reporting', E_ALL);

use App\Email;
use Laravel\Lumen\Routing\Controller as BaseController;

class EmailController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get($limit = 0)
    {
        if ($limit > 0) {
            return json_encode(Email::all()->take($limit));
        } else {
            return json_encode(Email::all());
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function getById($id)
    {
        $obj = Email::where('id', $id)->get();
        if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
            return json_encode($obj);
        } else {
            return json_encode(
                array(
                    "success" => false,
                    "error" => "NotFound"
                )
            );
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function getByUser($id)
    {
        $obj = Email::where('user', $id)->get();
        if ($obj && !is_null($obj) && !empty($obj) && sizeof($obj) > 0) {
            return json_encode($obj);
        } else {
            return json_encode(
                array(
                    "success" => false,
                    "error" => "NotFound"
                )
            );
        }
    }

}