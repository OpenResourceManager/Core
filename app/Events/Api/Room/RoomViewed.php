<?php

namespace App\Events\Api\Room;

use App\Http\Models\API\Duty;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

class RoomViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * RoomViewed constructor.
     * @param Duty $duty
     */
    public function __construct(Duty $duty)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Room',
                'viewed ' . $duty->label . '.',
                $user->id,
                'building-o',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $duty->label . '.');
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