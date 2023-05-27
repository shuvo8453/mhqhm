<?php
//@abdullah zahid joy

use App\Http\Controllers\Backend\ClassTimeController;
use App\Http\Controllers\Backend\Core\ActivityLogController;
use App\Http\Controllers\Backend\Core\AdminController;
use App\Http\Controllers\Backend\Core\AdminRoleController;
use App\Http\Controllers\Backend\Core\DashboardController;
use App\Http\Controllers\Backend\Core\PaymentController;
use App\Http\Controllers\Backend\Core\ProfileController;
use App\Http\Controllers\Backend\Core\RecycleBinController;
use App\Http\Controllers\Backend\Core\RoutineController;
use App\Http\Controllers\Backend\Core\TeacherController;
use App\Http\Controllers\Backend\Core\UserController;
use App\Http\Controllers\Backend\DonationController;
use App\Http\Controllers\Backend\FeeController;
use App\Http\Controllers\Backend\FeeTypeController;
use App\Http\Controllers\Backend\GroupController;
use App\Http\Controllers\Backend\GroupSubjectController;
use App\Http\Controllers\Backend\SubjectController;
use App\Http\Controllers\Backend\System\ModuleController;
use App\Http\Controllers\Backend\System\SettingController;
use App\Http\Controllers\Backend\System\SystemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DonorController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//'as'=>'admin.',
Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function() {
    //mandatory route
    Route::get('module/{name}', [ModuleController::class,'instruction'])->name('Module.instruction');
    Route::get('system-update', [SystemController::class,'update'])->name('system.update');

    Route::put('/password/change', [PasswordController::class, 'update'])->name('password.change');
    Route::post('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])->name('two-factor.enable');
    Route::delete('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])->name('two-factor.disable');
    Route::get('/two-factor-recovery-codes', [RecoveryCodeController::class, 'index']) ->name('two-factor.recovery-codes')
        ->middleware(['password.confirm:admin.password.confirm']);
    Route::post('/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
        ->middleware(['password.confirm:admin.password.confirm']);

    Route::get('get-subject/{id}', [RoutineController::Class,'getSubject'])->name('.get-subject');



    Route::group(['as'=>'admin.profile','prefix'=>'profile'],function (){
        Route::controller(ProfileController::class)->group(function() {
            Route::get('/', 'profile');
            Route::get('/privacy', 'privacy')->name('.privacy');
            Route::get('/privacy/recovery', 'recovery')->name('.recovery');
            Route::put('/image', 'changeProfile')->name('.image.update');
            Route::put('/information', 'update')->name('.information.update');
        });
    });
    Route::group(['middleware'=>'permission:admin'],function(){
        Route::resource('admin-role', AdminRoleController::Class,['names'=>"AdminRole"]);
        Route::resource('admin', AdminController::Class,['names'=>"Admin"]);

        Route::resource('setting', SettingController::Class,['names'=>"Setting"])->only('index','store','update');
        Route::get('setting/{id}', [SettingController::Class,"destroy"])->name('Setting.destroy');

        Route::get('activities', [ActivityLogController::class,'index'])->name('ActivityLog.index');

        Route::resource('user', UserController::Class,['names'=>'User']);
        Route::resource('teacher', TeacherController::Class,['names'=>'Teacher']);
        Route::resource('routine', RoutineController::Class,['names'=>'Routine']);
        Route::get('user/{id}/status/{status}', [UserController::class,'changeStatus'])->name('User.changeStatus');
        Route::get('user/{id}/admission', [UserController::class,'print'])->name('User.print');

        Route::group(['as'=>'RecycleBin','prefix'=>'recycle','middleware'=>'permission:admin'],function (){
            Route::get('/', [RecycleBinController::class,'index'])->name('.index');
            Route::get('/delete/{model}/{id}', [RecycleBinController::class,'delete'])->name('.delete');
            Route::get('/recover/{model}/{id}', [RecycleBinController::class,'recover'])->name('.recover');
        });

        Route::group(['as'=>'Module','prefix'=>'module'],function (){
            Route::controller(ModuleController::class)->group(function() {
                Route::get('/', 'index')->name('.index');
                Route::post('/store', 'store')->name('.store');
            });
        });
        Route::get('dashboard', [DashboardController::class,'index'])->name('Dashboard.index');

        Route::group(['as'=>'Payment','prefix'=>'payment'], function (){
            Route::controller(PaymentController::class)->group(function() {
                Route::get('/', 'index')->name('.index');
                Route::get('/view/{id}', 'view')->name('.view');
                Route::get('/due', 'due')->name('.due');
                Route::get('invoice', 'invoice')->name('.invoice');
                Route::post('due', 'pay')->name('.pay');
                Route::get('pdf/{id}', 'pdf')->name('.pdf');
            });
        });

        //module routes
 	    Route::resource('donor', DonorController::Class,['names'=>'Donor']);
 	    Route::resource('classTime', ClassTimeController::Class,['names'=>'ClassTime']);
        Route::resource('donation', DonationController::Class,['names'=>'Donation']);
        Route::resource('groupSubject', GroupSubjectController::Class,['names'=>'GroupSubject']);
        Route::resource('subject', SubjectController::Class,['names'=>'Subject']);
        Route::resource('fee', FeeController::Class,['names'=>'Fee']);
        Route::resource('feeType', FeeTypeController::Class,['names'=>'FeeType']);
        Route::resource('group', GroupController::Class,['names'=>'Group']);
    });
});
