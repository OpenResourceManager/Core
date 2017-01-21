<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Department;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;
use App\Events\Event;

class DepartmentsViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $departmentIds;

    /**
     * DepartmentsViewed constructor.
     * @param array $departmentIds
     */
    public function __construct($departmentIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Department',
                'viewed ' . count($departmentIds) . ' departments',
                $user->id,
                'cubes',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($departmentIds) . ' departments', $departmentIds);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     *
     * public function broadcastOn()
     * {
     * return new PrivateChannel('channel-name');
     * }
     */
}