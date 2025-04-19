<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\ObjectTypeController;
use App\Http\Controllers\SeoroleController;
use App\Http\Controllers\UniqueController;
use App\Http\Controllers\StatsController;
Route::get('/', function () {
    return redirect('projects');
});
Auth::routes();
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::resource('users', \App\Http\Controllers\UserController::class);

});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/fetch-data', [ProjectController::class, 'fetchData'])->name('projects.fetchData');
    Route::get('/get-districts/{name}', [ProjectController::class, 'getDistricts'])
        ->name('getDistricts');
    Route::post('/projects/main_store_phy', [ProjectController::class, 'main_store_phy'])
        ->name('projects.main_store_phy');
    Route::post('/projects/main_store_jur', [ProjectController::class, 'main_store_jur'])
        ->name('projects.main_store_jur');
    Route::post('/projects/store-all', [ProjectController::class, 'storeAll'])->name('projects.storeAll');
    Route::get('/projects/create/search-simlists', [ProjectController::class, 'searchSimlists'])->name('projects.searchSimlists');
    Route::get('/projects/create/search-hardwares', [ProjectController::class, 'searchHardwares'])->name('hardwares.searchHardwares');
    Route::get('/projects/create/get-next-ident-id', [ProjectController::class, 'getNextIdentId'])->name('projects.getNextIdentId');

    Route::delete('/projects/invoices/delete', [ProjectController::class, 'deleteInvoice'])
        ->name('projects.deleteInvoice');
    Route::get('/databases', [DatabaseController::class, 'index'])->name('db.index');
    Route::post('/databases/backup', [DatabaseController::class, 'backup'])->name('db.backup');
    Route::get('/databases/download', [DatabaseController::class, 'download'])->name('db.download');
    Route::post('/invoices/download', [ProjectController::class, 'makeinvoice'])->name('invoice.download');

    Route::get('/update-finances', [FinanceController::class, 'updateFinances'])->name('update.finances');
    Route::post('projects/{id}/check-status', [ProjectController::class, 'checkStatus'])->name('projects.checkStatus');
    Route::post('projects/{id}/update-status', [ProjectController::class, 'updateStatus'])->name('projects.updateStatus');
    Route::get('/simlists' , [\App\Http\Controllers\SimlistController::class , 'index'])-> name('simlists.index');
    Route::get('/simlists/create' , [\App\Http\Controllers\SimlistController::class , 'create'])-> name('simlists.create');

    Route::post('/simlists/store', [\App\Http\Controllers\SimlistController::class, 'store'])->name('simlists.store');
    Route::get('/simlists/edit/{id}', [\App\Http\Controllers\SimlistController::class, 'edit'])->name('simlists.edit');
    Route::match(['put' , 'patch'], '/simlists/edit/{id}', [\App\Http\Controllers\SimlistController::class, 'update'])->name('simlists.update');




    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




    Route::resource('hardwares', \App\Http\Controllers\HardwareController::class);
    Route::post('/projects/{id}/export', [ProjectController::class, 'export'])->name('projects.export');
    Route::post('/projects/{id}/exportact', [ProjectController::class, 'exportact'])->name('projects.exportact');

    Route::get('/hardwares', [\App\Http\Controllers\HardwareController::class, 'index'])->name('hardwares.index');
    Route::get('/update-discounts', [FinanceController::class, 'applyDiscounts'])->name('update.discounts');
    Route::get('/search-items', [ProjectController::class, 'searchItems'])->name('projects.search');
    Route::post('/projects/{project}/generate-id-marz', [ProjectController::class, 'generatePaymanagirIdMarz'])
        ->name('projects.generatePaymanagirIdMarz');
    Route::resource('prices' , \App\Http\Controllers\PriceController::class);
    Route::get('payments/create/{finance}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments/store', [PaymentController::class, 'store'])->name('payments.store');
//Route::get('payments/{finance}', [PaymentController::class, 'show'])->name('payments.show');


    Route::get('/finances', [FinanceController::class, 'index'])->name('finances.index');
    Route::get('/finances/years', [FinanceController::class, 'getYears'])->name('finances.getYears');
    Route::get('/finances/months', [FinanceController::class, 'getMonths'])->name('finances.getMonths');
    Route::get('/finances/projects', [FinanceController::class, 'getProjects'])->name('finances.getProjects');

//Route::get('payments/create/{finance}', [PaymentController::class, 'create'])->name('payments.create');
//Route::post('payments/store', [PaymentController::class, 'store'])->name('payments.store');


    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/project/{project}', [PaymentController::class, 'projectPayments'])->name('payments.projectPayments');

// Дополнительный роут для оплаты в проект напрямую (без finance_id)
    Route::get('payments/project/{project}/create', [PaymentController::class, 'createForProject'])->name('payments.createForProject');
//Route::get('payments/search', [PaymentController::class, 'search'])->name('payments.search');
//Route::post('payments/storeForProject', [PaymentController::class, 'storeForProject'])->name('payments.storeForProject');

    Route::get('payments/search', [PaymentController::class, 'search'])->name('payments.search');
    Route::post('payments/storeForProject', [PaymentController::class, 'storeForProject'])->name('payments.storeForProject');


    Route::get('/invoices', [ProjectController::class, 'showInvoices'])->name('projects.invoices');
    Route::get('/invoices/download', [ProjectController::class, 'downloadInvoice'])->name('projects.downloadInvoice');


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





    Route::get('object-types/list', [ObjectTypeController::class, 'list'])
        ->name('object_types.list');
// Возвращает HTML таблицы (для модалки).

    Route::get('object-types/create', [ObjectTypeController::class, 'create'])
        ->name('object_types.create');
// Возвращает HTML формы (для модалки).

    Route::post('object-types/store', [ObjectTypeController::class, 'store'])
        ->name('object_types.store');
// Обработчик POST для создания.

    Route::get('object-types/{id}/edit', [ObjectTypeController::class, 'edit'])
        ->name('object_types.edit');
// Возвращает HTML формы редактирования.

    Route::put('object-types/{id}', [ObjectTypeController::class, 'update'])
        ->name('object_types.update');

    Route::delete('object-types/{id}', [ObjectTypeController::class, 'destroy'])
        ->name('object_types.destroy');
    Route::get('seoroles/list', [SeoroleController::class, 'list'])
        ->name('seoroles.list');
    Route::get('seoroles/create', [SeoroleController::class, 'create'])
        ->name('seoroles.create');
    Route::post('seoroles/store', [SeoroleController::class, 'store'])
        ->name('seoroles.store');
    Route::get('seoroles/{id}/edit', [SeoroleController::class, 'edit'])
        ->name('seoroles.edit');
    Route::put('seoroles/{id}', [SeoroleController::class, 'update'])
        ->name('seoroles.update');
    Route::delete('seoroles/{id}', [SeoroleController::class, 'destroy'])
        ->name('seoroles.destroy');
    Route::get('/finances/searchProjects', [FinanceController::class, 'searchProjects'])->name('finances.searchProjects');
    Route::get('/payments/bydate', [PaymentController::class, 'paymentsByDate'])->name('payments.bydate');
    Route::resource('uniques', UniqueController::class)->name('uniques');         // теперь полный CRUD
    Route::get('uniques/{unique}/export', [UniqueController::class,'export'])
        ->name('uniques.export');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])
        ->name('dashboard.chartData');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// API для динамических графиков
    Route::get('/api/years',     [DashboardController::class, 'apiYears']);
    Route::get('/api/payments-by-month', [DashboardController::class, 'apiMonthlyStats']);
    Route::get('/api/payments-by-day',   [DashboardController::class, 'apiDailyStats']);

});
