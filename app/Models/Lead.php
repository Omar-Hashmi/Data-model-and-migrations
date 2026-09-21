<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = ['pipeline_stage_id', 'first_name', 'last_name', 'email', 'phone', 'source', 'status', 'estimated_value', 'notes', 'last_contacted_at', 'next_follow_up_at', 'converted_at'];

    protected function casts(): array
    {
        return ['estimated_value' => 'decimal:2', 'last_contacted_at' => 'datetime', 'next_follow_up_at' => 'datetime', 'converted_at' => 'datetime'];
    }

    public function pipelineStage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
