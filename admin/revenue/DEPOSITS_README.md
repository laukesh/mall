# Deposits admin notes

This commit adds a simple Model, Repository, Controller, Blade views and a Policy stub for the existing `deposits` table.

Next steps (manual):

1. Register the Policy: in app/Providers/AuthServiceProvider.php add:

    protected $policies = [
        // ...
        App\Models\Deposit::class => App\Policies\DepositPolicy::class,
    ];

2. Add routes (example) to routes/web.php or a routes file loaded by your admin area:

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web', 'auth']], function () {
        Route::group(['prefix' => 'revenue', 'as' => 'revenue.'], function () {
            Route::resource('deposits', App\Http\Controllers\Admin\Revenue\DepositController::class);
        });
    });

3. If you use spatie/laravel-permission, create the permissions: `view deposits`, `create deposits`, `edit deposits`, `delete deposits` and assign to roles.

4. Adjust relationships in the model to match your actual LeaseAgreement model location.

