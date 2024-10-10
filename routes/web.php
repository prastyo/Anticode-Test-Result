<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:09
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DataSukuController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAgamaController;
use App\Http\Controllers\DataCacatController;
use App\Http\Controllers\DataKawinController;
use App\Http\Controllers\DataKursuController;
use App\Http\Controllers\KelahiranController;
use App\Http\Controllers\PerangkatController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DataBahasaController;
use App\Http\Controllers\DataJabatanController;
use App\Http\Controllers\DataAsuransiController;
use App\Http\Controllers\DataPekerjaanController;
use App\Http\Controllers\DataAkseptorKbController;
use App\Http\Controllers\DataPendidikanController;
use App\Http\Controllers\DataStatusDasarController;
use App\Http\Controllers\DataWarganegaraController;
use App\Http\Controllers\DataSakitMenahunController;
use App\Http\Controllers\DataGolonganDarahController;
use App\Http\Controllers\DataJenisPersalinanController;
use App\Http\Controllers\DataHubunganKeluargaController;
use App\Http\Controllers\DataTempatDilahirkanController;
use App\Http\Controllers\DataPenolongKelahiranController;

// To understand routes, see the bottom of this file
Route::get('/localization', [LanguageController::class , 'change'])->name('localization');

Route::controller(AuthController::class)->middleware(['guest'])->group(function(){
    Route::get(  '/',                       'index'             )->name('login'           );
    Route::post( '/',                       'login'             )->name('login.auth'      );
    Route::get(  '/forgot-password',        'forgotPasswordForm')->name('password.request');
    Route::post( '/forgot-password',        'sendResetLink'     )->name('password.email'  );
    Route::get(  '/reset-password/{token}', 'resetForm'         )->name('password.reset'  );
    Route::post( '/reset-password',         'updatePassword'    )->name('password.update' );
});

Route::middleware(['auth'])->group(function(){
    Route::get( '/profile',   [ProfileController::class, 'index' ]  )->name('profile'       );
    Route::put( '/profile',   [ProfileController::class, 'update']  )->name('profile.update');
    Route::get( '/logout',    [AuthController::class,    'logout']  )->name('logout'        );

    Route::controller(DashboardController::class)->prefix('dashboard')->group(function(){
        Route::get('/',                    'index'              )->name('dashboard'                  );
        Route::get('/jenis-kelamin',       'jenisKelamin'       )->name('widget.jenis-kelamin'       );
        Route::get('/jenis-persalinan',    'jenisPersalinan'    )->name('widget.jenis-persalinan'    );
        Route::get('/kawin',               'kawin'              )->name('widget.kawin'               );
        Route::get('/agama',               'agama'              )->name('widget.agama'               );
        Route::get('/penduduk',            'penduduk'           )->name('widget.penduduk'            );
        Route::get('/jenis-keuangan',      'jenisKeuangan'      )->name('widget.jenis-keuangan'      );
    });

    /*
    * Role Routes
    */
    Route::controller(RoleController::class)->prefix('roles')->group(function(){
        Route::get(    '/',                    'index'     )->name('roles'           );
        Route::get(    '/list/{id?}/{plain?}', 'show'      )->name('roles.show'      );
        Route::post(   '/create',              'store'     )->name('roles.store'     );
        Route::post(   '/datatables',          'datatables')->name('roles.datatables');
        Route::put(    '/{id}',                'update'    )->name('roles.update'    );
        Route::delete( '/',                    'delete'    )->name('roles.delete'    );
    });

    /*
    * Permission Routes
    */
    Route::controller(PermissionController::class)->prefix('permissions')->group(function(){
        Route::get(    '/',           'index'     )->name('permissions'           );
        Route::get(    '/{id}',       'show'      )->name('permissions.show'      );
        Route::post(   '/create',     'store'     )->name('permissions.store'     );
        Route::post(   '/datatables', 'datatables')->name('permissions.datatables');
        Route::put(    '/{id}',       'update'    )->name('permissions.update'    );
        Route::delete( '/',           'delete'    )->name('permissions.delete'    );
    });

    /*
    * Data Agama Routes
    */
    Route::controller(DataAgamaController::class)->prefix('data-agamas')->group(function(){
        Route::get(    '/',           'index'     )->name('data-agamas'           );
        Route::get(    '/{id}',       'show'      )->name('data-agamas.show'      );
        Route::post(   '/create',     'store'     )->name('data-agamas.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-agamas.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-agamas.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-agamas.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-agamas.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-agamas.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-agamas.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-agamas.update'    );
        Route::delete( '/',           'delete'    )->name('data-agamas.delete'    ); // Move to the trash
    });

    /*
    * Data Akseptor Kb Routes
    */
    Route::controller(DataAkseptorKbController::class)->prefix('data-akseptor-kbs')->group(function(){
        Route::get(    '/',           'index'     )->name('data-akseptor-kbs'           );
        Route::get(    '/{id}',       'show'      )->name('data-akseptor-kbs.show'      );
        Route::post(   '/create',     'store'     )->name('data-akseptor-kbs.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-akseptor-kbs.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-akseptor-kbs.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-akseptor-kbs.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-akseptor-kbs.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-akseptor-kbs.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-akseptor-kbs.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-akseptor-kbs.update'    );
        Route::delete( '/',           'delete'    )->name('data-akseptor-kbs.delete'    ); // Move to the trash
    });

    /*
    * Data Asuransi Routes
    */
    Route::controller(DataAsuransiController::class)->prefix('data-asuransis')->group(function(){
        Route::get(    '/',           'index'     )->name('data-asuransis'           );
        Route::get(    '/{id}',       'show'      )->name('data-asuransis.show'      );
        Route::post(   '/create',     'store'     )->name('data-asuransis.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-asuransis.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-asuransis.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-asuransis.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-asuransis.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-asuransis.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-asuransis.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-asuransis.update'    );
        Route::delete( '/',           'delete'    )->name('data-asuransis.delete'    ); // Move to the trash
    });

    /*
    * Data Bahasa Routes
    */
    Route::controller(DataBahasaController::class)->prefix('data-bahasas')->group(function(){
        Route::get(    '/',           'index'     )->name('data-bahasas'           );
        Route::get(    '/{id}',       'show'      )->name('data-bahasas.show'      );
        Route::post(   '/create',     'store'     )->name('data-bahasas.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-bahasas.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-bahasas.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-bahasas.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-bahasas.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-bahasas.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-bahasas.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-bahasas.update'    );
        Route::delete( '/',           'delete'    )->name('data-bahasas.delete'    ); // Move to the trash
    });

    /*
    * Data Cacat Routes
    */
    Route::controller(DataCacatController::class)->prefix('data-cacats')->group(function(){
        Route::get(    '/',           'index'     )->name('data-cacats'           );
        Route::get(    '/{id}',       'show'      )->name('data-cacats.show'      );
        Route::post(   '/create',     'store'     )->name('data-cacats.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-cacats.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-cacats.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-cacats.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-cacats.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-cacats.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-cacats.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-cacats.update'    );
        Route::delete( '/',           'delete'    )->name('data-cacats.delete'    ); // Move to the trash
    });

    /*
    * Data Golongan Darah Routes
    */
    Route::controller(DataGolonganDarahController::class)->prefix('data-golongan-darahs')->group(function(){
        Route::get(    '/',           'index'     )->name('data-golongan-darahs'           );
        Route::get(    '/{id}',       'show'      )->name('data-golongan-darahs.show'      );
        Route::post(   '/create',     'store'     )->name('data-golongan-darahs.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-golongan-darahs.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-golongan-darahs.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-golongan-darahs.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-golongan-darahs.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-golongan-darahs.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-golongan-darahs.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-golongan-darahs.update'    );
        Route::delete( '/',           'delete'    )->name('data-golongan-darahs.delete'    ); // Move to the trash
    });

    /*
    * Data Hubungan Keluarga Routes
    */
    Route::controller(DataHubunganKeluargaController::class)->prefix('data-hubungan-keluargas')->group(function(){
        Route::get(    '/',           'index'     )->name('data-hubungan-keluargas'           );
        Route::get(    '/{id}',       'show'      )->name('data-hubungan-keluargas.show'      );
        Route::post(   '/create',     'store'     )->name('data-hubungan-keluargas.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-hubungan-keluargas.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-hubungan-keluargas.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-hubungan-keluargas.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-hubungan-keluargas.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-hubungan-keluargas.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-hubungan-keluargas.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-hubungan-keluargas.update'    );
        Route::delete( '/',           'delete'    )->name('data-hubungan-keluargas.delete'    ); // Move to the trash
    });

    /*
    * Data Jabatan Routes
    */
    Route::controller(DataJabatanController::class)->prefix('data-jabatans')->group(function(){
        Route::get(    '/',           'index'     )->name('data-jabatans'           );
        Route::get(    '/{id}',       'show'      )->name('data-jabatans.show'      );
        Route::post(   '/create',     'store'     )->name('data-jabatans.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-jabatans.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-jabatans.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-jabatans.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-jabatans.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-jabatans.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-jabatans.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-jabatans.update'    );
        Route::delete( '/',           'delete'    )->name('data-jabatans.delete'    ); // Move to the trash
    });

    /*
    * Data Jenis Persalinan Routes
    */
    Route::controller(DataJenisPersalinanController::class)->prefix('data-jenis-persalinans')->group(function(){
        Route::get(    '/',           'index'     )->name('data-jenis-persalinans'           );
        Route::get(    '/{id}',       'show'      )->name('data-jenis-persalinans.show'      );
        Route::post(   '/create',     'store'     )->name('data-jenis-persalinans.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-jenis-persalinans.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-jenis-persalinans.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-jenis-persalinans.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-jenis-persalinans.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-jenis-persalinans.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-jenis-persalinans.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-jenis-persalinans.update'    );
        Route::delete( '/',           'delete'    )->name('data-jenis-persalinans.delete'    ); // Move to the trash
    });

    /*
    * Data Kawin Routes
    */
    Route::controller(DataKawinController::class)->prefix('data-kawins')->group(function(){
        Route::get(    '/',           'index'     )->name('data-kawins'           );
        Route::get(    '/{id}',       'show'      )->name('data-kawins.show'      );
        Route::post(   '/create',     'store'     )->name('data-kawins.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-kawins.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-kawins.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-kawins.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-kawins.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-kawins.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-kawins.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-kawins.update'    );
        Route::delete( '/',           'delete'    )->name('data-kawins.delete'    ); // Move to the trash
    });

    /*
    * Data Kursus Routes
    */
    Route::controller(DataKursuController::class)->prefix('data-kursuses')->group(function(){
        Route::get(    '/',           'index'     )->name('data-kursuses'           );
        Route::get(    '/{id}',       'show'      )->name('data-kursuses.show'      );
        Route::post(   '/create',     'store'     )->name('data-kursuses.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-kursuses.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-kursuses.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-kursuses.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-kursuses.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-kursuses.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-kursuses.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-kursuses.update'    );
        Route::delete( '/',           'delete'    )->name('data-kursuses.delete'    ); // Move to the trash
    });

    /*
    * Data Pekerjaan Routes
    */
    Route::controller(DataPekerjaanController::class)->prefix('data-pekerjaans')->group(function(){
        Route::get(    '/',           'index'     )->name('data-pekerjaans'           );
        Route::get(    '/{id}',       'show'      )->name('data-pekerjaans.show'      );
        Route::post(   '/create',     'store'     )->name('data-pekerjaans.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-pekerjaans.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-pekerjaans.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-pekerjaans.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-pekerjaans.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-pekerjaans.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-pekerjaans.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-pekerjaans.update'    );
        Route::delete( '/',           'delete'    )->name('data-pekerjaans.delete'    ); // Move to the trash
    });

    /*
    * Data Pendidikan Routes
    */
    Route::controller(DataPendidikanController::class)->prefix('data-pendidikans')->group(function(){
        Route::get(    '/',           'index'     )->name('data-pendidikans'           );
        Route::get(    '/{id}',       'show'      )->name('data-pendidikans.show'      );
        Route::post(   '/create',     'store'     )->name('data-pendidikans.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-pendidikans.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-pendidikans.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-pendidikans.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-pendidikans.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-pendidikans.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-pendidikans.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-pendidikans.update'    );
        Route::delete( '/',           'delete'    )->name('data-pendidikans.delete'    ); // Move to the trash
    });

    /*
    * Data Penolong Kelahiran Routes
    */
    Route::controller(DataPenolongKelahiranController::class)->prefix('data-penolong-kelahirans')->group(function(){
        Route::get(    '/',           'index'     )->name('data-penolong-kelahirans'           );
        Route::get(    '/{id}',       'show'      )->name('data-penolong-kelahirans.show'      );
        Route::post(   '/create',     'store'     )->name('data-penolong-kelahirans.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-penolong-kelahirans.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-penolong-kelahirans.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-penolong-kelahirans.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-penolong-kelahirans.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-penolong-kelahirans.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-penolong-kelahirans.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-penolong-kelahirans.update'    );
        Route::delete( '/',           'delete'    )->name('data-penolong-kelahirans.delete'    ); // Move to the trash
    });

    /*
    * Data Sakit Menahun Routes
    */
    Route::controller(DataSakitMenahunController::class)->prefix('data-sakit-menahuns')->group(function(){
        Route::get(    '/',           'index'     )->name('data-sakit-menahuns'           );
        Route::get(    '/{id}',       'show'      )->name('data-sakit-menahuns.show'      );
        Route::post(   '/create',     'store'     )->name('data-sakit-menahuns.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-sakit-menahuns.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-sakit-menahuns.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-sakit-menahuns.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-sakit-menahuns.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-sakit-menahuns.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-sakit-menahuns.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-sakit-menahuns.update'    );
        Route::delete( '/',           'delete'    )->name('data-sakit-menahuns.delete'    ); // Move to the trash
    });

    /*
    * Data Status Dasar Routes
    */
    Route::controller(DataStatusDasarController::class)->prefix('data-status-dasars')->group(function(){
        Route::get(    '/',           'index'     )->name('data-status-dasars'           );
        Route::get(    '/{id}',       'show'      )->name('data-status-dasars.show'      );
        Route::post(   '/create',     'store'     )->name('data-status-dasars.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-status-dasars.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-status-dasars.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-status-dasars.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-status-dasars.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-status-dasars.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-status-dasars.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-status-dasars.update'    );
        Route::delete( '/',           'delete'    )->name('data-status-dasars.delete'    ); // Move to the trash
    });

    /*
    * Data Suku Routes
    */
    Route::controller(DataSukuController::class)->prefix('data-sukus')->group(function(){
        Route::get(    '/',           'index'     )->name('data-sukus'           );
        Route::get(    '/{id}',       'show'      )->name('data-sukus.show'      );
        Route::post(   '/create',     'store'     )->name('data-sukus.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-sukus.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-sukus.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-sukus.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-sukus.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-sukus.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-sukus.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-sukus.update'    );
        Route::delete( '/',           'delete'    )->name('data-sukus.delete'    ); // Move to the trash
    });

    /*
    * Data Tempat Dilahirkan Routes
    */
    Route::controller(DataTempatDilahirkanController::class)->prefix('data-tempat-dilahirkans')->group(function(){
        Route::get(    '/',           'index'     )->name('data-tempat-dilahirkans'           );
        Route::get(    '/{id}',       'show'      )->name('data-tempat-dilahirkans.show'      );
        Route::post(   '/create',     'store'     )->name('data-tempat-dilahirkans.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-tempat-dilahirkans.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-tempat-dilahirkans.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-tempat-dilahirkans.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-tempat-dilahirkans.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-tempat-dilahirkans.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-tempat-dilahirkans.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-tempat-dilahirkans.update'    );
        Route::delete( '/',           'delete'    )->name('data-tempat-dilahirkans.delete'    ); // Move to the trash
    });

    /*
    * Data Warganegara Routes
    */
    Route::controller(DataWarganegaraController::class)->prefix('data-warganegaras')->group(function(){
        Route::get(    '/',           'index'     )->name('data-warganegaras'           );
        Route::get(    '/{id}',       'show'      )->name('data-warganegaras.show'      );
        Route::post(   '/create',     'store'     )->name('data-warganegaras.store'     );
        Route::post(   '/datatables', 'datatables')->name('data-warganegaras.datatables');
        Route::post(   '/excel',      'excel'     )->name('data-warganegaras.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('data-warganegaras.pdf'       );
        Route::post(   '/print',      'print'     )->name('data-warganegaras.print'     );
        Route::post(   '/purge',      'purge'     )->name('data-warganegaras.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('data-warganegaras.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('data-warganegaras.update'    );
        Route::delete( '/',           'delete'    )->name('data-warganegaras.delete'    ); // Move to the trash
    });

    /*
    * Kelahiran Routes
    */
    Route::controller(KelahiranController::class)->prefix('kelahirans')->group(function(){
        Route::get(    '/',           'index'     )->name('kelahirans'           );
        Route::get(    '/{id}',       'show'      )->name('kelahirans.show'      );
        Route::post(   '/create',     'store'     )->name('kelahirans.store'     );
        Route::post(   '/datatables', 'datatables')->name('kelahirans.datatables');
        Route::post(   '/excel',      'excel'     )->name('kelahirans.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('kelahirans.pdf'       );
        Route::post(   '/print',      'print'     )->name('kelahirans.print'     );
        Route::post(   '/purge',      'purge'     )->name('kelahirans.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('kelahirans.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('kelahirans.update'    );
        Route::delete( '/',           'delete'    )->name('kelahirans.delete'    ); // Move to the trash
    });

    /*
    * Keuangan Routes
    */
    Route::controller(KeuanganController::class)->prefix('keuangans')->group(function(){
        Route::get(    '/',           'index'     )->name('keuangans'           );
        Route::get(    '/{id}',       'show'      )->name('keuangans.show'      );
        Route::post(   '/create',     'store'     )->name('keuangans.store'     );
        Route::post(   '/datatables', 'datatables')->name('keuangans.datatables');
        Route::post(   '/excel',      'excel'     )->name('keuangans.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('keuangans.pdf'       );
        Route::post(   '/print',      'print'     )->name('keuangans.print'     );
        Route::post(   '/purge',      'purge'     )->name('keuangans.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('keuangans.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('keuangans.update'    );
        Route::delete( '/',           'delete'    )->name('keuangans.delete'    ); // Move to the trash
    });

    /*
    * Penduduk Routes
    */
    Route::controller(PendudukController::class)->prefix('penduduks')->group(function(){
        Route::get(    '/',           'index'     )->name('penduduks'           );
        Route::get(    '/{id}',       'show'      )->name('penduduks.show'      );
        Route::post(   '/create',     'store'     )->name('penduduks.store'     );
        Route::post(   '/datatables', 'datatables')->name('penduduks.datatables');
        Route::post(   '/excel',      'excel'     )->name('penduduks.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('penduduks.pdf'       );
        Route::post(   '/print',      'print'     )->name('penduduks.print'     );
        Route::post(   '/purge',      'purge'     )->name('penduduks.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('penduduks.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('penduduks.update'    );
        Route::delete( '/',           'delete'    )->name('penduduks.delete'    ); // Move to the trash
    });

    /*
    * Perangkat Routes
    */
    Route::controller(PerangkatController::class)->prefix('perangkats')->group(function(){
        Route::get(    '/',           'index'     )->name('perangkats'           );
        Route::get(    '/{id}',       'show'      )->name('perangkats.show'      );
        Route::post(   '/create',     'store'     )->name('perangkats.store'     );
        Route::post(   '/datatables', 'datatables')->name('perangkats.datatables');
        Route::post(   '/excel',      'excel'     )->name('perangkats.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('perangkats.pdf'       );
        Route::post(   '/print',      'print'     )->name('perangkats.print'     );
        Route::post(   '/purge',      'purge'     )->name('perangkats.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('perangkats.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('perangkats.update'    );
        Route::delete( '/',           'delete'    )->name('perangkats.delete'    ); // Move to the trash
    });

    /*
    * Users Routes
    */
    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::get(    '/',           'index'     )->name('users'           );
        Route::get(    '/{id}',       'show'      )->name('users.show'      );
        Route::post(   '/create',     'store'     )->name('users.store'     );
        Route::post(   '/datatables', 'datatables')->name('users.datatables');
        Route::post(   '/excel',      'excel'     )->name('users.excel'     );
        Route::post(   '/pdf',        'pdf'       )->name('users.pdf'       );
        Route::post(   '/print',      'print'     )->name('users.print'     );
        Route::post(   '/purge',      'purge'     )->name('users.purge'     ); // Permanently deleted, cannot be undone
        Route::post(   '/restore',    'restore'   )->name('users.restore'   ); // Restore from the trash
        Route::put(    '/{id}',       'update'    )->name('users.update'    );
        Route::delete( '/',           'delete'    )->name('users.delete'    ); // Move to the trash
    });
});

// To understand routes, see the top of this file