<?php

namespace App;

enum FriendStatus : string
{
    case PENDING = 'pending';

    case ACCEPTED = 'accepted';

    case BLOCKED = 'blocked' ;

}
