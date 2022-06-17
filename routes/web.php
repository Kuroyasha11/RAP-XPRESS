<?php

use App\Http\Controllers\DashboardCourierController;
use App\Http\Controllers\DashboardCourierDeliveryController;
use App\Http\Controllers\DashboardCourierPickUpController;
use App\Http\Controllers\DashboardDeliveryController;
use App\Http\Controllers\DashboardPackageController;
use App\Http\Controllers\DashboardPartnerController;
use App\Http\Controllers\DashboardPickUpController;
use App\Http\Controllers\DashboardRegistrationController;
use App\Http\Controllers\DashboardReportController;
use App\Http\Controllers\DashboardRequestController;
use App\Http\Controllers\DashboardSlideController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OlshopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TrackingController;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

// Front End
Route::get('/', function () {
    return view('frontend.index', [
        'title' => 'Home',
        'slide' => Slide::all()
    ]);
});
// BUAT EDIT BAGIAN POST NYA

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/register/checkSlug', [RegisterController::class, 'checkSlug']);

Route::resource('/kurir', DriverController::class)->only(['index']);

Route::resource('/online-shop', OlshopController::class)->only(['index', 'show']);

Route::resource('/tracking', TrackingController::class)->only(['index', 'show']);

// Back End
Route::get('/dashboard', function () {
    return view('backend.index', [
        'title' => 'Dashboard',
        'partners' => User::where('is_mitra', 1)->latest()->paginate(50)->withQueryString()
    ]);
})->middleware('auth');

// UBAH PASSWORD USERc(ADMIN & MITRA)
Route::get('/dashboard/profile/password/{password}/edit', [ProfileController::class, 'password'])->middleware(['auth']);
Route::put('/dashboard/profile/password/{password}', [ProfileController::class, 'change'])->middleware(['auth']);

//Admin
Route::resource('/dashboard/partner', DashboardPartnerController::class)->except(['create', 'store'])->middleware(['auth', 'admin']);

Route::resource('/dashboard/registration', DashboardRegistrationController::class)->except(['create', 'store'])->middleware(['auth', 'admin']);

Route::get('/dashboard/permintaan/checkSlug', [DashboardRequestController::class, 'checkSlug'])->middleware(['auth', 'admin']);
Route::put('/dashboard/permintaan/terima/{terima}', [DashboardRequestController::class, 'terima'])->middleware(['auth', 'admin']);
Route::resource('/dashboard/permintaan', DashboardRequestController::class)->middleware(['auth', 'admin']);

Route::put('/dashboard/pengiriman/selesai/{selesai}', [DashboardDeliveryController::class, 'selesai'])->middleware(['auth', 'admin']);
Route::resource('/dashboard/pengiriman', DashboardDeliveryController::class)->middleware(['auth', 'admin'])->except(['create', 'store']);

Route::get('/dashboard/pickup/paket/{paket}', [DashboardPickUpController::class, 'paket'])->middleware(['auth', 'admin']);
Route::put('/dashboard/pickup/paket/{paket}', [DashboardPickUpController::class, 'tambahpaket'])->middleware(['auth', 'admin']);
Route::put('/dashboard/pickup/paket/delete/{delete}', [DashboardPickUpController::class, 'hapuspaket'])->middleware(['auth', 'admin']);
Route::put('/dashboard/pickup/kurir/{kurir}', [DashboardPickUpController::class, 'terimakurir'])->middleware(['auth', 'admin']);
Route::put('/dashboard/pickup/selesai/{selesai}', [DashboardPickUpController::class, 'selesai'])->middleware(['auth', 'admin']);
Route::resource('/dashboard/pickup', DashboardPickUpController::class)->middleware(['auth', 'admin']);
Route::get('/dashboard/kurir/paket/{paket}', [DashboardCourierController::class, 'paket'])->middleware(['auth', 'admin']);
Route::put('/dashboard/kurir/paket/{paket}', [DashboardCourierController::class, 'tambahpaket'])->middleware(['auth', 'admin']);
Route::put('/dashboard/kurir/paket/delete/{delete}', [DashboardCourierController::class, 'hapuspaket'])->middleware(['auth', 'admin']);
Route::put('/dashboard/kurir/kurir/{kurir}', [DashboardCourierController::class, 'terimakurir'])->middleware(['auth', 'admin']);
Route::put('/dashboard/kurir/selesai/{selesai}', [DashboardCourierController::class, 'selesai'])->middleware(['auth', 'admin']);
Route::resource('/dashboard/kurir', DashboardCourierController::class)->middleware(['auth', 'admin']);

Route::get('/dashboard/laporan', [DashboardReportController::class, 'index'])->middleware(['auth', 'admin']);

Route::resource('/dashboard/slide', DashboardSlideController::class)->middleware(['auth', 'admin'])->except(['show']);
// Route::resource('/dashboard/post', DashboardPostController::class)->middleware(['auth', 'admin']);

//Mitra
Route::get('/dashboard/profile/{profile}', [ProfileController::class, 'show'])->middleware(['auth', 'mitra']);
Route::put('/dashboard/profile/{profile}', [ProfileController::class, 'update'])->middleware(['auth', 'mitra']);

Route::get('/dashboard/paket/checkSlug', [DashboardPackageController::class, 'checkSlug'])->middleware(['auth', 'mitra']);
Route::get('/dashboard/paket/resi/{resi}', [DashboardPackageController::class, 'resi'])->middleware(['auth']);
Route::resource('/dashboard/paket', DashboardPackageController::class)->middleware(['auth', 'mitra']);

Route::put('/dashboard/pengambilan-paket/paket/{paket}', [DashboardCourierPickUpController::class, 'selesai'])->middleware(['auth', 'mitra']);
Route::get('/dashboard/pengambilan-paket/paket/{paket}', [DashboardCourierPickUpController::class, 'paket'])->middleware(['auth', 'mitra']);
Route::resource('/dashboard/pengambilan-paket', DashboardCourierPickUpController::class)->middleware(['auth', 'mitra'])->except(['create', 'store', 'edit', 'destroy']);
Route::put('/dashboard/pengiriman-paket/paket/{paket}', [DashboardCourierDeliveryController::class, 'selesai'])->middleware(['auth', 'mitra']);
Route::get('/dashboard/pengiriman-paket/paket/{paket}', [DashboardCourierDeliveryController::class, 'paket'])->middleware(['auth', 'mitra']);
Route::resource('/dashboard/pengiriman-paket', DashboardCourierDeliveryController::class)->middleware(['auth', 'mitra'])->except(['create', 'store', 'edit', 'destroy']);
