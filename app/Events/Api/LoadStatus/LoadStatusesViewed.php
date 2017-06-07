<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\LoadStatus;

use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;
use App\Events\Event;

class LoadStatusesViewed extends Event
{
    /**
     * LoadStatusesViewed constructor.
     * @param array $loadStatusIds
     */
    public function __construct($loadStatusIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'LoadStatus',
                'viewed ' . count($loadStatusIds) . ' load statuses',
                $user->id,
                'fa-university',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($loadStatusIds) . ' courses', $loadStatusIds);
    }
}