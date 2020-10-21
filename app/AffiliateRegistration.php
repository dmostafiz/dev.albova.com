<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AffiliateRegistration extends Model
{
    public function child()
    {
        return $this->belongsTo(User::class, 'child_id');
    }
}
