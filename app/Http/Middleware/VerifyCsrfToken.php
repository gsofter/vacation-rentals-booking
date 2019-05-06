<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // 'ajax/searchResult',
        '/getMail',
        '/ajax/rooms/add_photos/*',
        '/ajax/rooms/manage-listing/*/*',
        '/ajax/searchlisting',
        '/ajax/users/reviews',
        '/ajax/wishlist_create',
        '/ajax/save_wishlist',
        '/ajax/rooms/price_calculation',
        '/ajax/membership/*',
        '/ajax/paypal/subscribe/createplan',
        '/ajax/paypal/subscribe/excute',
        '/ajax/rooms/post_subscribe_property/*',
        '/ajax/chat/sendmessage',
        '/pusher/webhook/*',
        // '/ajax/chat/fileupload'
        '/ba/account/register',
    ];
}
