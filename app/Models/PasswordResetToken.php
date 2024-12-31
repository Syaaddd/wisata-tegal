<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetToken extends Model
{
    protected $table            = 'passwordresettokens';
    protected $DBGroup          = 'default';
    protected $allowedFields    = ['email', 'token', 'created_at'];

}
