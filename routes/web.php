<?php


use App\Http\Controllers\FinanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/update-finances', [FinanceController::class, 'updateFinances'])->name('update.finances');
Route::post('projects/{id}/check-status', [ProjectController::class, 'checkStatus'])->name('projects.checkStatus');
Route::post('projects/{id}/update-status', [ProjectController::class, 'updateStatus'])->name('projects.updateStatus');
Route::get('/simlists' , [\App\Http\Controllers\SimlistController::class , 'index'])-> name('simlists.index');
Route::get('/simlists/create' , [\App\Http\Controllers\SimlistController::class , 'create'])-> name('simlists.create');

Route::post('/simlists/store', [\App\Http\Controllers\SimlistController::class, 'store'])->name('simlists.store');
Route::get('/simlists/edit/{id}', [\App\Http\Controllers\SimlistController::class, 'edit'])->name('simlists.edit');
Route::match(['put' , 'patch'], '/simlists/edit/{id}', [\App\Http\Controllers\SimlistController::class, 'update'])->name('simlists.update');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


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
    Route::get('/projects/create/search-hardwares', [ProjectController::class, 'searchHardwares'])->name('projects.searchHardwares');

    Route::get('/projects/create/get-next-ident-id', [ProjectController::class, 'getNextIdentId'])->name('projects.getNextIdentId');
});
Route::resource('hardwares', \App\Http\Controllers\HardwareController::class);
Route::post('/projects/{id}/export', [ProjectController::class, 'export'])->name('projects.export');
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
