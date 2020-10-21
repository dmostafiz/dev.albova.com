<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AffiliateEarningRecord extends Model
{
    public function child()
    {
        return $this->belongsTo(User::class, 'child_id');
    }
}
