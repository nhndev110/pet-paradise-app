<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    const STATUS_AVAILABLE = 'available';
    const STATUS_SOLD = 'sold';
    const STATUS_RESERVED = 'reserved';

    protected function rules()
    {
        return [
            'status' => 'required|in:' . implode(',', [
                self::STATUS_AVAILABLE,
                self::STATUS_SOLD,
                self::STATUS_RESERVED,
            ])
        ];
    }
}
