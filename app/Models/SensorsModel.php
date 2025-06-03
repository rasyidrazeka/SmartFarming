<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorsModel extends Model
{
    use HasFactory;

    protected $table = 'sensors';
    protected $primaryKey = 'id';
    protected $fillable = ['sensor_name', 'table_id'];

    public function dhts()
    {
        return $this->hasMany(DHTSModel::class, 'sensor_id', 'id');
    }

    public function npks()
    {
        return $this->hasMany(NPKSModel::class, 'sensor_id', 'id');
    }
}
