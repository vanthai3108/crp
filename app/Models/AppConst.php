<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppConst extends Model
{
    const ROLE_ADMIN = 1;
    const ROLE_TRAINER = 2;
    const ROLE_TRAINEE = 3;
}
