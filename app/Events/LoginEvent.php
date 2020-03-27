<?php

namespace App\Events;

use App\Usuarios;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LoginEvent implements ShouldBroadcast
{
	use InteractsWithSockets, SerializesModels;

    public $usuario;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Usuarios $usuario)
    {
        $this->usuario = $usuario;
    }

	/**
	* Determine if events and listeners should be automatically discovered.
	*
	* @return bool
	*/

	public function broadcastOn()
	{
		return ['my-channel'];
	}

	public function broadcastAs()
	{
		return 'my-event';
	}
}
