<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DHTSModel extends Model
{
    use HasFactory;

    protected $table = 'dhts';
    protected $primaryKey = 'id';
    protected $fillable = ['temperature', 'humidity', 'luminosity', 'created_at', 'read_at'];

    public function sensors(): BelongsTo
    {
        return $this->belongsTo(SensorsModel::class, 'sensor_id', 'id');
    }
}
