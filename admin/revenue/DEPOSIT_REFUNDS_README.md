# Deposit Refunds admin notes

This commit adds a simple Model, Repository, Controller, Blade views and a Policy stub for the existing `deposit_refunds` table.

Next steps (manual):

1. Register the Policy: in app/Providers/AuthServiceProvider.php add:

    protected $policies = [
        // ...
        App\Models\DepositRefund::class => App\Policies\DepositRefundPolicy::class,
    ];

2. Add routes (example) to routes/web.php or a routes file loaded by your admin area:

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web', 'auth']], function () {
        Route::group(['prefix' => 'revenue', 'as' => 'revenue.'], function () {
            Route::resource('deposit_refunds', App\Http\Controllers\Admin\Revenue\DepositRefundController::class);
        });
    });

3. If you use spatie/laravel-permission, create the permissions: `view deposit refunds`, `create deposit refunds`, `edit deposit refunds`, `delete deposit refunds` and assign to roles.

4. Adjust relationships in the model to match your actual Deposit model location.

