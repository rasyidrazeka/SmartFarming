<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'user.account';
    protected $primaryKey = 'id';
    protected $fillable = ['urole_id', 'username', 'password', 'email', 'google_id', 'fullname', 'avatar', 'is_ban', 'created_at', 'updated_at', 'deleted_at'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(RoleModel::class, 'urole_id', 'id');
    }

    public function api_tokens()
    {
        return $this->hasMany(ApiTokenModel::class, 'user_id', 'id');
    }
}
