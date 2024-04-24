# Laravel Broadcasting Example

https://laravel.com/docs/10.x/broadcasting

## Stacks version
- **Laravel**: 10
- **PHP**: 8.3
- **Node**: 20.12
- **npm**: 10.5

## Installation
To install the required packages, run the following commands:

```bash
## Install Pusher PHP Server package
composer require pusher/pusher-php-server

## Install Laravel Echo and Pusher JavaScript libraries
npm install --save-dev laravel-echo pusher-js
```

## Configuration
Update your `.env` file to use the Pusher broadcasting driver:

```dotenv
BROADCAST_DRIVER=pusher
QUEUE_CONNECTION=sync
#QUEUE_CONNECTION=redis // Uncomment and set up if you want to use Redis for queue
```

## Usage
### Create Web Routes
Define a web route to trigger the event:

```php
use App\Http\Controllers\StudentController;

Route::get('ping', [StudentController::class, 'index']);
```

### Dispatch Event inside Controller
In your controller, dispatch the `PingEvent`:

```php
public function index()
{
    event(new PingEvent('sample data'));

    return "ping";
}
```

### Create `PingEvent` Event
Create the `PingEvent` event class:

```php
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PingEvent implements ShouldBroadcast
{
    public function __construct(public string $data)
    {
        //
    }

    // Other methods...
}
```

### Broadcasting Setup
Ensure broadcasting snippets are enabled in your `bootstrap.js` file:

```javascript
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.VITE_PUSHER_APP_KEY,
    cluster: process.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: process.env.VITE_PUSHER_HOST ? process.env.VITE_PUSHER_HOST : `ws-${process.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: process.env.VITE_PUSHER_PORT ?? 80,
    wssPort: process.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (process.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss']
});
```

### Define Channel in `app.js`
Listen for the event on the specified channel:

```javascript
Echo.channel('ping-channel')
    .listen('.ping-alias', (e) => {
        console.log('pong!');
        console.log({ e });
    });
```

### Include JavaScript in Blade
In your blade file, include the JavaScript:

```php
<head>
    <!-- Other head content -->
    @vite('resources/js/app.js')
</head>
```
