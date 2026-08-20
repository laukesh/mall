<?php

use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
if (!function_exists('get_value')) {

    function get_value($table, $where = [], $column = 'id')
    {
        $query = DB::table($table);

        if(!empty($where)){
            foreach($where as $k=>$v){
                $query->where($k,$v);
            }
        }

        return $query->value($column);
    }

}

if (!function_exists('get_row')) {

    function get_row($table, $where = [])
    {
        $query = DB::table($table);

        if(!empty($where)){
            foreach($where as $k=>$v){
                $query->where($k,$v);
            }
        }

        return $query->first();
    }

}

if (!function_exists('get_all')) {

    function get_all($table, $where = [])
    {
        $query = DB::table($table);

        if(!empty($where)){
            foreach($where as $k=>$v){
                $query->where($k,$v);
            }
        }

        return $query->get();
    }

}

if (!function_exists('insert_get_id')) {

    function insert_get_id($table, $data)
    {
        return DB::table($table)->insertGetId($data);
    }

}

if (!function_exists('status_name')) {

    function status_name($status)
    {
        $arr=[
            0=>'Inactive',
            1=>'Active'
        ];

        return $arr[$status] ?? '';
    }

}



if (!function_exists('roles_array')) {

    function roles_array()
    {
        static $roles = null;

        if ($roles === null) {

            $roles = [];

            $data = Role::select('id','name')->get();

            foreach ($data as $row) {
                $roles[$row->id] = $row->name;
            }

        }

        return $roles;
    }

}


if (!function_exists('getStatusName')) {
    function getStatusName($statusId) {
        $status = DB::table('all_status')->where('id', $statusId)->first();
        return $status ? $status->name : 'Unknown';
    }
}

if (!function_exists('getRoleName')) {
    function getRoleName($roleId) {
        $role = DB::table('roles')->where('id', $roleId)->first();
        return $role ? ($role->name ?? $role->role ?? 'Unknown') : 'Unknown';
    }
}

if (!function_exists('current_auth_user')) {
    function current_auth_user()
    {
        foreach (['callcenter', 'sf', 'admin', 'web'] as $guard) {
            if (auth()->guard($guard)->check()) {
                return auth()->guard($guard)->user();
            }
        }

        return null;
    }
}

if (!function_exists('user_id')) {
    function user_id()
    {
        $user = current_auth_user();
        return $user ? $user->id : null;
    }
}

if (!function_exists('user_name')) {
    function user_name()
    {
        $user = current_auth_user();
        return $user ? $user->name : null;
    }
}

if (!function_exists('user_mobile')) {
    function user_mobile()
    {
        $user = current_auth_user();
        return $user ? $user->mobile : null;
    }
}

if (!function_exists('user_email')) {
    function user_email()
    {
        $user = current_auth_user();
        return $user ? $user->email : null;
    }
}

if (!function_exists('user_role_id')) {
    function user_role_id()
    {
        $user = current_auth_user();
        return $user ? ($user->role_id ?? null) : null;
    }
}

if (!function_exists('user_role_name')) {
    function user_role_name()
    {
        $roleId = user_role_id();
        return $roleId ? getRoleName($roleId) : null;
    }
}

if (!function_exists('entity_id')) {
    function entity_id()
    {
        $user = current_auth_user();
        return $user ? ($user->entity_id ?? null) : null;
    }
}

if (!function_exists('agent_id')) {
    function agent_id()
    {
        return user_id();
    }
}
if (!function_exists('role_id')) {
    function role_id()
    {
        return user_role_id();
    }
}

if (!function_exists('agent_name')) {
    function agent_name()
    {
        return user_name();
    }
}

if (!function_exists('agent_email')) {
    function agent_email()
    {
        return user_email();
    }
}

if (!function_exists('sf_id')) {
    function sf_id()
    {
        if (auth()->guard('sf')->check()) {
            return auth()->guard('sf')->user()->id;
        }
        return null;
    }
}

if (!function_exists('isSF')) {
    function isSF()
    {
        return auth()->guard('sf')->check();
    }
    
}
if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return auth()->guard('admin')->check();
    }
    
}
if (!function_exists('isCallCenter')) {
    function isCallCenter()
    {
        return auth()->guard('callcenter')->check();
    }
    
}
if (!function_exists('callcenter_id')) {
    function callcenter_id()
    {
        if (auth()->guard('callcenter')->check()) {
            return auth()->guard('callcenter')->user()->id;
        }
        return null;
    }
}
if (!function_exists('id')) {
    function id()
    {
        return user_id();
    }
}
