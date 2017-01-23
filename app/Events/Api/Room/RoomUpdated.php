<?php

namespace App\Events\Api\Room;

use App\Events\Event;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RoomUpdated extends Event
{

    /**
     * RoomUpdated constructor.
     * @param Room $room
     */
    public function __construct(Room $room)
    {
        Log::info('Room Updated:', [
            'id' => $room->id,
            'code' => $room->code,
            'label' => $room->label
        ]);

        if ($user = auth()->user()) {

            $data_to_secure = json_encode([
                'data' => $room->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'updated',
                'type' => 'room',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Room',
                'updated the room: ' . $room->label() . '.',
                $room->id,
                'building-o',
                'bg-lime'
            );
        }
    }
}