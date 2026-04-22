use App\Http\Controllers\mahasiswaController;
use App\Http\Controllers\dosenController;
use App\Http\Controllers\prodiController;

Route::resource('mahasiswa', mahasiswaController::class);
Route::resource('dosen', dosenController::class);
Route::resource('prodi', prodiController::class);