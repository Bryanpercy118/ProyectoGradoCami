<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\PreinscripcionController;
use App\Http\Controllers\AspiranteController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\AlumnoNotasController;
use App\Http\Controllers\MedicalDocumentController;

// Salones
Route::resource('salones', SalonController::class)->names([
    'index' => 'salones.index',
    'create' => 'salones.create',
    'store' => 'salones.store',
    'show' => 'salones.show',
    'edit' => 'salones.edit',
    'update' => 'salones.update',
    'destroy' => 'salones.destroy',
]);

// Docentes
Route::middleware(['auth'])->group(function () {
    Route::resource('docentes', TeacherController::class)
        ->parameters(['docentes' => 'profesor'])
        ->names([
            'index'   => 'docentes.index',
            'create'  => 'docentes.create',
            'store'   => 'docentes.store',
            'show'    => 'docentes.show',
            'edit'    => 'docentes.edit',
            'update'  => 'docentes.update',
            'destroy' => 'docentes.destroy',
        ]);
});

// Asignaturas
Route::middleware(['auth'])->group(function () {
    Route::resource('asignaturas', SubjectController::class)
        ->parameters(['asignaturas' => 'subject']) // <-- clave para binding con $subject
        ->names([
            'index'   => 'asignaturas.index',
            'create'  => 'asignaturas.create',
            'store'   => 'asignaturas.store',
            'show'    => 'asignaturas.show',
            'edit'    => 'asignaturas.edit',
            'update'  => 'asignaturas.update',
            'destroy' => 'asignaturas.destroy',
        ]);
});

Route::get('/preinscripciones', [PreinscripcionController::class, 'index'])->name('preinscripciones.index');
Route::post('/preinscripciones', [PreinscripcionController::class, 'store'])->name('preinscripciones.store');
Route::get('/preinscripciones/{id}/edit', [PreinscripcionController::class, 'edit'])->name('preinscripciones.edit');
Route::put('/preinscripciones/{id}', [PreinscripcionController::class, 'update'])->name('preinscripciones.update');
Route::delete('/preinscripciones/{id}', [PreinscripcionController::class, 'destroy'])->name('preinscripciones.destroy');
Route::get('/preinscripciones/{id}/json', [PreinscripcionController::class, 'json'])->name('preinscripciones.json');
Route::get('/preinscripciones/{id}', [PreinscripcionController::class, 'show'])->name('preinscripciones.show');


Route::resource('aspirantes', AspiranteController::class)->names([
    'index' => 'aspirantes.index',
    'create' => 'aspirantes.create',
    'store' => 'aspirantes.store',
    'show' => 'aspirantes.show',
    'edit' => 'aspirantes.edit',
    'update' => 'aspirantes.update',
    'destroy' => 'aspirantes.destroy',
]);

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');

Route::controller(AuthController::class)->middleware('loggedin')->group(function() {
    Route::get('login', 'loginView')->name('login.index');
    Route::post('login', 'login')->name('login.check');
});


Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
Route::get('/matriculas/crear', [MatriculaController::class, 'create'])->name('matriculas.create'); // ?aspirante_id=...
Route::post('/matriculas', [MatriculaController::class, 'store'])->name('matriculas.store');
Route::get('/matriculas/{matricula}', [MatriculaController::class, 'show'])->name('matriculas.show');

Route::get('/alumno', [DashboardController::class, 'index'])->name('alumno.dashboard');



Route::get('/inscripcion', [AspiranteController::class, 'index'])->name('aspirantes.indexa');
Route::get('/colsanor/home', [LandingController::class, 'index'])->name('landing');

// RUTAS PARA PERIODOS

Route::get('/periodos', [PeriodoController::class, 'index'])->name('periodos.index');
Route::get('/periodos/{periodo}', [PeriodoController::class, 'show'])->name('periodos.show');
Route::post('/periodos', [PeriodoController::class, 'store'])->name('periodos.store');
Route::put('/periodos/{periodo}', [PeriodoController::class, 'update'])->name('periodos.update');
Route::delete('/periodos/{periodo}', [PeriodoController::class, 'destroy'])->name('periodos.destroy');

Route::middleware(['auth'])->group(function () {
    Route::resource('asignaciones', AsignacionController::class)
        ->parameters(['asignaciones' => 'asignacion'])
        ->names('asignaciones');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/documentos-medicos', [MedicalDocumentController::class, 'index'])->name('meddocs.index');
    Route::post('/documentos-medicos', [MedicalDocumentController::class, 'store'])->name('meddocs.store');
    Route::get('/documentos-medicos/{documento}/descargar', [MedicalDocumentController::class, 'download'])->name('meddocs.download');
    Route::delete('/documentos-medicos/{documento}', [MedicalDocumentController::class, 'destroy'])->name('meddocs.destroy');
});


Route::middleware(['auth'])
    ->prefix('alumno')->name('alumno.')
    ->group(function () {
        Route::get('/mis-notas', [AlumnoNotasController::class, 'index'])->name('mis_notas');
    });


Route::middleware(['auth'])
    ->prefix('docente/notas')->name('docente.notas.')
    ->group(function () {
        Route::get('/', [NotasController::class, 'index'])->name('index'); // Selector
        Route::get('/cargar', [NotasController::class, 'cargar'])->name('cargar'); // Pantalla de carga
        Route::get('/data', [NotasController::class, 'data'])->name('data'); // Datos JSON
        Route::post('/guardar', [NotasController::class, 'guardar'])->name('guardar');
    });

Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::controller(PageController::class)->group(function() {
        Route::get('/', 'dashboardOverview1')->name('dashboard-overview-1');
        Route::get('dashboard-overview-2-page', 'dashboardOverview2')->name('dashboard-overview-2');
        Route::get('dashboard-overview-3-page', 'dashboardOverview3')->name('dashboard-overview-3');
        Route::get('dashboard-overview-4-page', 'dashboardOverview4')->name('dashboard-overview-4');
        Route::get('categories-page', 'categories')->name('categories');
        Route::get('add-product-page', 'addProduct')->name('add-product');
        Route::get('asignaciones', 'asignaciones')->name('asignaciones');
        Route::get('product-list-page', 'productList')->name('product-list');
        Route::get('product-grid-page', 'productGrid')->name('product-grid');
        Route::get('periodos-page', 'periodos')->name('periodos');
        Route::get('transaction-list-page', 'transactionList')->name('transaction-list');
        Route::get('transaction-detail-page', 'transactionDetail')->name('transaction-detail');
        Route::get('seller-list-page', 'sellerList')->name('seller-list');
        Route::get('seller-detail-page', 'sellerDetail')->name('seller-detail');
        Route::get('reviews-page', 'reviews')->name('reviews');
        Route::get('inbox-page', 'inbox')->name('inbox');
        Route::get('file-manager-page', 'fileManager')->name('file-manager');
        Route::get('point-of-sale-page', 'pointOfSale')->name('point-of-sale');
        Route::get('pre-inscripciones', 'preinscripciones')->name('preinscripciones');
        Route::get('chat-page', 'chat')->name('chat');
        Route::get('post-page', 'post')->name('post');
        Route::get('calendar-page', 'calendar')->name('calendar');
        Route::get('crud-data-list-page', 'crudDataList')->name('crud-data-list');
        Route::get('crud-form-page', 'crudForm')->name('crud-form');
        Route::get('users-layout-1-page', 'usersLayout1')->name('users-layout-1');
        Route::get('users-layout-2-page', 'usersLayout2')->name('users-layout-2');
        Route::get('users-layout-3-page', 'usersLayout3')->name('users-layout-3');
        Route::get('profile-overview-1-page', 'profileOverview1')->name('profile-overview-1');
        Route::get('profile-overview-2-page', 'profileOverview2')->name('profile-overview-2');
        Route::get('profile-overview-3-page', 'profileOverview3')->name('profile-overview-3');
        Route::get('wizard-layout-1-page', 'wizardLayout1')->name('wizard-layout-1');
        Route::get('wizard-layout-2-page', 'wizardLayout2')->name('wizard-layout-2');
        Route::get('wizard-layout-3-page', 'wizardLayout3')->name('wizard-layout-3');
        Route::get('blog-layout-1-page', 'blogLayout1')->name('blog-layout-1');
        Route::get('blog-layout-2-page', 'blogLayout2')->name('blog-layout-2');
        Route::get('blog-layout-3-page', 'blogLayout3')->name('blog-layout-3');
        Route::get('pricing-layout-1-page', 'pricingLayout1')->name('pricing-layout-1');
        Route::get('pricing-layout-2-page', 'pricingLayout2')->name('pricing-layout-2');
        Route::get('invoice-layout-1-page', 'invoiceLayout1')->name('invoice-layout-1');
        Route::get('invoice-layout-2-page', 'invoiceLayout2')->name('invoice-layout-2');
        Route::get('faq-layout-1-page', 'faqLayout1')->name('faq-layout-1');
        Route::get('faq-layout-2-page', 'faqLayout2')->name('faq-layout-2');
        Route::get('faq-layout-3-page', 'faqLayout3')->name('faq-layout-3');
        Route::get('login-page', 'login')->name('login');
        Route::get('register-page', 'register')->name('register');
        Route::get('error-page-page', 'errorPage')->name('error-page');
        Route::get('update-profile-page', 'updateProfile')->name('update-profile');
        Route::get('change-password-page', 'changePassword')->name('change-password');
        Route::get('regular-table-page', 'regularTable')->name('regular-table');
        Route::get('tabulator-page', 'tabulator')->name('tabulator');
        Route::get('modal-page', 'modal')->name('modal');
        Route::get('slide-over-page', 'slideOver')->name('slide-over');
        Route::get('notification-page', 'notification')->name('notification');
        Route::get('tab-page', 'tab')->name('tab');
        Route::get('accordion-page', 'accordion')->name('accordion');
        Route::get('button-page', 'button')->name('button');
        Route::get('alert-page', 'alert')->name('alert');
        Route::get('progress-bar-page', 'progressBar')->name('progress-bar');
        Route::get('tooltip-page', 'tooltip')->name('tooltip');
        Route::get('dropdown-page', 'dropdown')->name('dropdown');
        Route::get('typography-page', 'typography')->name('typography');
        Route::get('icon-page', 'icon')->name('icon');
        Route::get('loading-icon-page', 'loadingIcon')->name('loading-icon');
        Route::get('regular-form-page', 'regularForm')->name('regular-form');
        Route::get('datepicker-page', 'datepicker')->name('datepicker');
        Route::get('tom-select-page', 'tomSelect')->name('tom-select');
        Route::get('file-upload-page', 'fileUpload')->name('file-upload');
        Route::get('wysiwyg-editor-classic', 'wysiwygEditorClassic')->name('wysiwyg-editor-classic');
        Route::get('wysiwyg-editor-inline', 'wysiwygEditorInline')->name('wysiwyg-editor-inline');
        Route::get('wysiwyg-editor-balloon', 'wysiwygEditorBalloon')->name('wysiwyg-editor-balloon');
        Route::get('wysiwyg-editor-balloon-block', 'wysiwygEditorBalloonBlock')->name('wysiwyg-editor-balloon-block');
        Route::get('wysiwyg-editor-document', 'wysiwygEditorDocument')->name('wysiwyg-editor-document');
        Route::get('validation-page', 'validation')->name('validation');
        Route::get('chart-page', 'chart')->name('chart');
        Route::get('slider-page', 'slider')->name('slider');
        Route::get('image-zoom-page', 'imageZoom')->name('image-zoom');
    });
});
