<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\{
    AuthController,
    DashboardController,
    KeydinController,
    ItemController,
    ItemTypeController,
    UnitController,
    AskariController,
    PersonController,
    UserRoleController,
    UserController,
    StoreController,
    SubDepartmentController,
    DepartmentController,
    DistrictController,
    RegionController,
    StateController,
    CountryController,
    EmployeeController,
    SubMenuController,
    ShaqsiyaadkaController,
    ImportController,
    ExportController,
    MenuController,
    ShaxdaHubkaController,
    ArmyApiController
};

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/test-pgsql', function () {
    try {
        $db = DB::connection('pgsql2')->getPDO();
        $name = DB::connection('pgsql2')->getDatabaseName();

        return "PGSQL connection OK! Database: " . $name;
    } catch (\Exception $e) {
        return "PGSQL connection FAILED: " . $e->getMessage();
    }
});

Route::get('/test-army', function () {
    return \App\Models\Army::limit(5)->get();
});

Route::middleware('guest')->group(function () {

    // Login & OTP
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('otp.verify.form');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');

    // Password reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (All Logged In Users)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard (accessible to all authenticated users)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Shaxda Hubka
    Route::get('/shaxda-hubka', [ShaxdaHubkaController::class, 'index'])->name('shaxda.hubka');
});


/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Keydin Routes (Clean & Fixed)
    |--------------------------------------------------------------------------
    */
    Route::prefix('keydin')->group(function () {
        Route::get('/raadi', [KeydinController::class, 'searchKeydin'])->name('keydin.raadi');
        Route::get('/list', [KeydinController::class, 'keydin'])->name('keydin.list');
        Route::post('/check-serial', [KeydinController::class, 'checkSerial'])->name('keydin.checkSerial');
        Route::post('/remove-image', [KeydinController::class, 'removeImage'])->name('keydin.removeImage');
    });

    // Clean **resource** for Keydin (NO conflicts!)
    Route::resource('keydin', KeydinController::class)
        ->parameters(['keydin' => 'id'])
        ->where(['id' => '[0-9]+']);

    // Routes-ka Cusub ee lagu daray (Wareejinta Hubka & Search)
    Route::get('/get-stores-by-department', [KeydinController::class, 'getStoresByDepartment'])->name('get.stores.by.department');
    Route::post('/keydin/sii-shaqsi', [KeydinController::class, 'siiHubShaqsi'])->name('hubka.sii.shaqsi');
    Route::post('/keydin/sii-askari', [KeydinController::class, 'siiHubAskari'])->name('hubka.sii.askari');
    Route::post('/search-askari', [KeydinController::class, 'searchAskari'])->name('askari.search');    
    Route::post('/shaqsi/search', [KeydinController::class, 'searchShaqsi'])->name('shaqsi.search');

    Route::get('/armies', [ArmyApiController::class, 'index']);
    Route::get('/armies/{id}', [ArmyApiController::class, 'show']);






    Route::prefix('askari')->name('askari.')->group(function () {
        Route::get('/', [AskariController::class, 'index'])->name('index'); // List all
        Route::get('/create', [AskariController::class, 'create'])->name('create'); // Form create
        Route::post('/store', [AskariController::class, 'store'])->name('store'); // Save new
        Route::get('/{id}/edit', [AskariController::class, 'edit'])->name('edit'); // Edit form
        Route::put('/{id}', [AskariController::class, 'update'])->name('update'); // Update
        Route::delete('/{id}', [AskariController::class, 'destroy'])->name('destroy'); // Delete
        Route::get('/{id}', [AskariController::class, 'show'])->name('show'); // View single
    });

    /*
    |--------------------------------------------------------------------------
    | Resource Controllers (Inta kale ee Routes-kaaga)
    |--------------------------------------------------------------------------
    */
    
    Route::resource('departments', DepartmentController::class);
    Route::resource('userRole', UserRoleController::class);
    Route::resource('units', UnitController::class);
    Route::resource('items', ItemController::class);

    Route::post('/items/{id}/toggle-status', [ItemController::class, 'toggleStatus'])
        ->name('items.toggleStatus');

    Route::resource('itemtypes', ItemTypeController::class);
    Route::resource('stores', StoreController::class);
    Route::resource('users', UserController::class);

    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');

    /* Shaqsiyaadka */
    Route::resource('shaqsiyaadka', ShaqsiyaadkaController::class);
    Route::get('/shaqsiyaadka/search', [ShaqsiyaadkaController::class, 'search'])->name('shaqsiyaadka.search');

    /* Persons */
    Route::resource('persons', PersonController::class);
    Route::get('/person/grid', [PersonController::class, 'getpersons'])->name('person.grid');
    Route::post('/person/import', [ImportController::class, 'importPersons'])->name('persons.import');
    Route::get('/person/export', [ExportController::class, 'PersonExport'])->name('persons.export');
    Route::post('/person/search', [PersonController::class, 'searchPerson'])->name('persons.search');

    /* Menu & Submenu */
    Route::resource('menus', MenuController::class);
    Route::resource('sub-menus', SubMenuController::class);

    /* Location (Country, State, Region, District) */
    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('regions', RegionController::class);
    Route::resource('districts', DistrictController::class);

    Route::get('get-states/{country}', [StateController::class, 'getStates']);
    Route::get('get-regions/{state}', [RegionController::class, 'getRegions']);
    Route::get('get-districts/{region}', [DistrictController::class, 'getDistricts']);

    /* Employees */
    Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('employees/{employee}', [EmployeeController::class, 'show'])
        ->name('employees.show')->whereNumber('employee');
    Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::put('employees/{employee}', [EmployeeController::class, 'update'])
        ->name('employees.update')->whereNumber('employee');
    Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])
        ->name('employees.destroy')->whereNumber('employee');
        
}); // <--- Halkaan ayuu ku xirmayaa Middleware Group-ka Admin-ka

Route::get('/clear-cache', function () {
    try {
        // Clear All Caches
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        Artisan::call('config:cache');
        

        return back()->with('success', 'All caches cleared successfully.');
    } catch (\Exception $e) {
        return back()->with('fail', 'Failed to clear cache: ' . $e->getMessage());
    }
});