# Laravel Socialite(gmail) Example

https://laravel.com/docs/10.x/socialite#main-content

## Stacks version
- **Laravel**: 10
- **PHP**: 8.3
- **Node**: 20.12
- **npm**: 10.5

## Installation
To install the required packages, run the following commands:

```bash
## Install Pest, laravel breeze and socialite
composer require pestphp/pest --dev
composer require pestphp/pest-plugin-laravel --dev
composer require laravel/breeze --dev
composer require laravel/socialite

## Install Laravel breeze libraries
php artisan breeze:install
```

## Configuration
Update your `.env` file to use the Pusher broadcasting driver:

```dotenv
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

## Usage
### Create Web Routes
Define a web route to trigger the event:

```php
Route::middleware('guest')->group(function () {
    Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google-auth.redirect');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google-auth.callback');
});
```

### Create `GoogleAuthController` Controller
Create the `GoogleAuthController` controller class:

```bash
php artisan make:controller Socialite\\GoogleAuthController
```

```php
use App\Models\User;
use Auth;
use Hash;
use Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate([
            'google_id' => $googleUser->getId(),
        ], [
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => Hash::make('password'),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
```
