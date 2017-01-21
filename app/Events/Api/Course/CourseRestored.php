<?php

namespace App\Events\Api\Course;

use App\Http\Models\API\Campus;
use Illuminate\Broadcasting\Channel;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class CourseRestored extends Event
{

    /**
     * CourseRestored constructor.
     * @param Course $course
     */
    public function __construct(Course $course)
    {
        if (auth()->user()) {

            Log::info('Course Restored:', [
                'id' => $course->id,
                'code' => $course->code,
                'label' => $course->label
            ]);

            $course->campus;

            $data_to_secure = json_encode([
                'data' => $course->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'restored',
                'type' => 'course',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Course',
                'restored a course: ' . $course->label() . '.',
                $course->id,
                'graduation-cap',
                'bg-lime'
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
//        return new PrivateChannel('account-events');
//    }
}