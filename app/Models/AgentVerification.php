<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentVerification extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'agent_verifications';

    // 👇 Add this relationship
    public function institutionData()
    {
        return $this->belongsTo(Institution::class, 'institution', 'id');
    }
}
