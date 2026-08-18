<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['role_name', 'role_description', 'status'];

    public static function getAll()
    {
        return self::orderBy('role_name')->get();
    }

    public static function updateById($id, array $data)
    {
        return self::where('id', $id)->update($data);
    }

    public static function deleteById($id)
    {
        return self::where('id', $id)->delete();
    }

    public static function find($id, $columns = ['*'])
    {
        return self::where('id', $id)->first($columns);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
