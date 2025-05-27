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
}
