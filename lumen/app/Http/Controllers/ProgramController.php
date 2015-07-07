<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 2:26 PM
 */

use App\Program;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProgramController extends BaseController
{
    /**
     * @param int $limit
     * @return string
     */
    public function get($limit = 0)
    {
        if ($limit > 0) {
            return json_encode(Program::all()->take($limit));
        } else {
            return json_encode(Program::all());
        }
    }

}