<?php

namespace App\Http\Helper;

class Helper
{

    // linkMentions helper function

    function linkMentions($content)
    {
        return preg_replace_callback('/@(\w+)/', function ($matches) {
            $username = $matches[1];
            $user = User::whereUsername($username)->first();
            if ($user) {
                return '<a href="' . route('users.profile', $user->username) . '">@' . $user->username . '</a>';
            } else {
                return '@' . $username; // No link if user doesn't exist
            }
        }, $content);
    }
}
