<?php

// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\PenerimaanDanaKebutuhan;
use App\Observers\PenerimaanDanaKebutuhanObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB; // WAJIB ADA

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('sequential_order', function ($attribute, $value, $parameters, $validator) {
            $tableName = $parameters[0];
            $foreignKeyColumn = $parameters[1];
            $foreignKeyValue = $parameters[2];
            $idColumnName = isset($parameters[3]) ? $parameters[3] : 'id'; // Nama kolom ID, default 'id'
            $ignoreId = isset($parameters[4]) ? $parameters[4] : null;     // ID yang diabaikan saat update

            if (is_null($value)) { // Jika urutan null, anggap valid
                return true;
            }

            // Cek apakah urutan ini adalah '0' (atau nilai awalmu, misal '1')
            // dan apakah sudah ada item lain atau ini adalah item pertama.
            $startOrderValue = 0; // Ganti ke 1 jika urutanmu mulai dari 1

            $baseQuery = DB::table($tableName)
                            ->where($foreignKeyColumn, $foreignKeyValue);
            if ($ignoreId) {
                $baseQuery->where($idColumnName, '!=', $ignoreId);
            }
            $existingOrders = $baseQuery->pluck('urutan')->filter(function($orderValue) {
                return !is_null($orderValue); // Hanya ambil urutan yang tidak null
            })->sort()->values()->toArray(); // Urutkan dan re-index

            if ($value == $startOrderValue) {
                // Boleh menjadi $startOrderValue jika tidak ada $startOrderValue lain (sudah dicover unique)
                // atau jika ini satu-satunya entri atau entri pertama yang di-set ke $startOrderValue.
                return true;
            }

            // Jika nilai > $startOrderValue, maka ($value - 1) harus ada di $existingOrders
            if ($value > $startOrderValue) {
                if (in_array($value - 1, $existingOrders)) {
                    return true;
                }
                // Khusus untuk kasus pertama kali input setelah $startOrderValue.
                // Jika $existingOrders hanya berisi $startOrderValue, dan $value adalah $startOrderValue + 1, maka valid.
                if (count($existingOrders) === 1 && $existingOrders[0] == $startOrderValue && $value == ($startOrderValue + 1)) {
                    return true;
                }
                // Jika tidak ada order sama sekali ($existingOrders kosong) dan $value adalah $startOrderValue
                if (empty($existingOrders) && $value == $startOrderValue) {
                     return true;
                }
            }
            return false;
        });

        Validator::replacer('sequential_order', function ($message, $attribute, $rule, $parameters) {
             return 'Urutan yang dimasukkan tidak berurutan. Pastikan urutan sebelumnya telah ada.';
        });

        App::setLocale(config('app.locale')); // Mengambil locale dari config
        Carbon::setLocale(config('app.locale')); // Mengatur locale untuk Carbon juga


        PenerimaanDanaKebutuhan::observe(PenerimaanDanaKebutuhanObserver::class); // <-- TAMBAHKAN INI

        Paginator::useBootstrapFive(); // Atau versi Bootstrap yang kamu pakai
    }
}