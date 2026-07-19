<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeminiConfig extends Model
{
    protected $fillable = [
        'name',
        'api_key',
        'model',
        'temperature',
        'max_output_tokens',
        'system_prompt',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'temperature' => 'float',
        'max_output_tokens' => 'integer',
    ];

    /**
     * Get the active configuration
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Set this config as active and deactivate others
     */
    public function setAsActive()
    {
        // Deactivate all others
        self::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        // Activate this one
        $this->update(['is_active' => true]);
    }
}
