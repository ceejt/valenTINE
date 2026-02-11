<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalChoice extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'proposal_choices';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'choice',
        'ip_address',
        'user_agent'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}