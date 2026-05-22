<?php

namespace Modules\Actors\Auth;

enum AuthRole: string
{
    case Guest = 'guest';
    case User = 'user';
    case Admin = 'admin';
    case Moderator = 'moderator';
}
