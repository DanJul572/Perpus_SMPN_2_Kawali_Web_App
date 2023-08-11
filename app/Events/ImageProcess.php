<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ImageProcess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($image, $path, $file_name, $type)
    {
        if ($type == 'put') {
            ImageManagerStatic::make($image)->resize(200, 200)->encode('jpg')->save(public_path($path) . $file_name);
        } else {
            $image_path = public_path($path) . $file_name;
            if  (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
