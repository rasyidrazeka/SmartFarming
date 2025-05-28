<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'user.role';
    protected $primaryKey = 'id';
    protected $fillable = ['code', 'name', 'created_at', 'updated_at'];
}
