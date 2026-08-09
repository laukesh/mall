

// Units resource routes added by automated change
Route::resource('units', App\Http\Controllers\Admin\UnitController::class)
    ->middleware([
        'index' => 'permission:units.view',
        'show' => 'permission:units.view',
        'create' => 'permission:units.create',
        'store' => 'permission:units.create',
        'edit' => 'permission:units.edit',
        'update' => 'permission:units.edit',
        'destroy' => 'permission:units.delete',
    ]);
