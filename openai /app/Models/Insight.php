<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    protected $fillable = [
        'summarize_logs',
        'input_data',
        'ai_response'
        ];
}
