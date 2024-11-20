<?php

namespace App;

enum UserStatus : string
{
    case Pending = 'pending';
    case Active = 'active';

    case Inactive = 'inactive';
    case Rejected = 'rejected';
    
}
