# Cam Charges admin notes

This commit adds a simple Model, Repository, Controller, Blade views and a Policy stub for the existing `cam_charges` table.

Next steps (manual):

1. Register the Policy: in app/Providers/AuthServiceProvider.php add:

    protected $policies = [
        // ...
        App\Models\CamCharge::class => App\Policies\CamChargePolicy::class,
    ];

2. Add routes (example) to routes/web.php or a routes file loaded by your admin area:

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web', 'auth']], function () {
        Route::group(['prefix' => 'revenue', 'as' => 'revenue.'], function () {
            Route::resource('cam_charges', App\Http\Controllers\Admin\Revenue\CamChargeController::class);
        });
    });

3. If you use spatie/laravel-permission, create the permissions: `view cam charges`, `create cam charges`, `edit cam charges`, `delete cam charges` and assign to roles.

4. Adjust relationships in the model to match your actual LeaseAgreement/Unit/InvoiceItem model locations.

