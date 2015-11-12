<?php namespace App\Http\Controllers\Type;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 1:42 PM
 */

use App\Model\Type\Campus;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;


class CampusController extends BaseController
{

    public function index()
    {
        $results = Campus::all();

        return  Response::json([
            'data' => $results->toArray()
        ], 200);
    }

}
