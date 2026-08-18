<?php

namespace App\Traits;

use DB;

trait CommonTraits
{
    public function checkAccess($module, $action)
    {
        // Simple check, can be expanded
        if (user_role_name() == 'superadmin') {
            return true;
        }
        // Assume permissions table: role_id, module, action
        $permission = DB::table('role_permissions')
            ->where('role_id', role_id())
            ->where('module', $module)
            ->where('action', $action)
            ->first();
        return $permission ? true : false;
    }

    public function logActivity($activity)
    {
        // Log to a table or file
        DB::table('activity_logs')->insert([
            'user_id' => id(),
            'activity' => $activity,
            'created_at' => now(),
        ]);
    }

    public function getUser()
    {
        return array_merge(session()->all(), [
            'user_id' => id(),
            'name' => user_name(),
            'email' => user_email(),
            'mobile' => user_mobile(),
            'role_id' => role_id(),
            'entity_id' => entity_id(),
            'auth_guard' => auth()->getDefaultDriver(),
        ]);
    }
    public function json_response($data, $status = 200)
    {
        return response()->json($data, $status);
    }
}