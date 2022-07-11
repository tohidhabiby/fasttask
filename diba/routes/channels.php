<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('orders.{token}', function ($user, $token) {
    return $user->hasActiveToken($token);
});
Broadcast::channel('todos.{token}', function ($user, $token) {
    return $user->hasActiveToken($token);
});
Broadcast::channel('symbols.{token}', function ($user, $token) {
    return $user->hasActiveToken($token);
});
Broadcast::channel('supervisorMessages.{token}', function ($user, $token) {
    return $user->hasActiveToken($token);
});
Broadcast::channel('symbolClosingPrice.{token}', function ($user, $token) {
    return $user->hasActiveToken($token);
});
Broadcast::channel('basketReports.{token}', function ($user, $token) {
    return $user->hasActiveToken($token);
});
Broadcast::channel('userReports.{token}', function ($user, $token) {
    return $user->hasActiveToken($token);
});
