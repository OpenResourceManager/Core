<?php

namespace App\Events\Api\Building;

use App\Http\Models\API\Building;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class BuildingCreated extends Event
{

    /**
     * BuildingCreated constructor.
     * @param Building $building
     */
    public function __construct(Building $building)
    {
        if (auth()->user()) {

            Log::info('Building Created:', [
                'id' => $building->id,
                'code' => $building->code,
                'label' => $building->label
            ]);

            $building->campus;

            $data_to_secure = json_encode([
                'data' => $building->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'created',
                'type' => 'building',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Building',
                'created a new building: ' . $building->label,
                $building->id,
                'building',
                'bg-green'
            );
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('channel-name');
//    }
}