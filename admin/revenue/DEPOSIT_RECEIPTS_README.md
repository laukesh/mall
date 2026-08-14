# Deposit Receipts admin notes

This commit adds a simple Model, Repository, Controller, Blade views and a Policy stub for the existing `deposit_receipts` table.

Next steps (manual):

1. Register the Policy: in app/Providers/AuthServiceProvider.php add:

    protected $policies = [
        // ...
        App\Models\DepositReceipt::class => App\Policies\DepositReceiptPolicy::class,
    ];

2. Add routes (example) to routes/web.php or a routes file loaded by your admin area:

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web', 'auth']], function () {
        Route::group(['prefix' => 'revenue', 'as' => 'revenue.'], function () {
            Route::resource('deposit_receipts', App\Http\Controllers\Admin\Revenue\DepositReceiptController::class);
        });
    });

3. If you use spatie/laravel-permission, create the permissions: `view deposit receipts`, `create deposit receipts`, `edit deposit receipts`, `delete deposit receipts` and assign to roles.

4. Adjust relationships in the model to match your actual Deposit model location.

