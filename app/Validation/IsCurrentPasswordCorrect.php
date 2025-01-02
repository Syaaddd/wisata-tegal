<?php

namespace App\Validation;
use App\Models\User;
use App\Libraries\CIAuth;
use App\Libraries\Hash;

class IsCurrentPasswordCorrect
{
   public function check_current_password($password): bool
   {
      $password = trim($password);
      $user_id = CIAuth::user()->id;
      $user = new User();
      $user_info = $user->asObject()->where('id', $user_id)->first();

      if (!Hash::check($password, $user_info->password)) {
         return false;
      }
      return true;
   }
}
