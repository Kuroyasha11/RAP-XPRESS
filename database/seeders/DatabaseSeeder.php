<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Shipping;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Viin Reynaldo',
            'slug' => 'viin-reynaldo',
            'email' => 'viinreynaldo@gmail.com',
            'no_hp' => '81274744500',
            'ktp_sim' => '1671082711010008',
            'username' => 'RAPXPRESS',
            'password' => bcrypt('121209'),
            'partner_id' => 1,
            'is_admin' => 1,
            'diterima' => 1
        ]);
        User::create([
            'name' => 'Ricky Andrean',
            'slug' => 'ricky-andrean',
            'email' => 'rickyandrean41@gmail.com',
            'no_hp' => '85357723770',
            'ktp_sim' => '1671082711010009',
            'username' => 'Kuroyasha',
            'password' => bcrypt('Ricky4424'),
            'partner_id' => 1,
            'is_admin' => 1,
            'diterima' => 1
        ]);
        User::create([
            'name' => 'Hendra Widyarto',
            'slug' => 'hendra-widyarto',
            'email' => 'hendrawidyarto1996@gmail.com',
            'no_hp' => '85788538332',
            'ktp_sim' => '167108271101010',
            'username' => 'Hendra4424',
            'password' => bcrypt('Hendra4424'),
            'partner_id' => 1,
            'is_admin' => 1,
            'diterima' => 1
        ]);
        // User::create([
        //     'name' => 'Kuro4424',
        //     'slug' => 'kuro4424',
        //     'email' => 'Kuro4424@gmail.com',
        //     'no_hp' => '085357723772',
        //     'ktp_sim' => '1671082711010030',
        //     'username' => 'Kuro4424',
        //     'password' => bcrypt('442460'),
        //     'partner_id' => 1,
        //     'is_mitra' => 1,
        //     'diterima' => 1
        // ]);
        // User::create([
        //     'name' => 'Rara4424',
        //     'slug' => 'rara4424',
        //     'email' => 'rara@gmail.com',
        //     'no_hp' => '0711442461',
        //     'ktp_sim' => '1671082711010020',
        //     'username' => 'Rara4424',
        //     'password' => bcrypt('442460'),
        //     'partner_id' => 2,
        //     'is_mitra' => 1,
        //     'diterima' => 1
        // ]);

        // User::create([
        //     'name' => 'Hendra Widyarto',
        //     'slug' => 'hendra-widyarto',
        //     'email' => 'hendrawidyarto1996@gmail.com',
        //     'no_hp' => '0711442462',
        //     'ktp_sim' => '1671082711010040',
        //     'username' => 'Hendra4424',
        //     'password' => bcrypt('Hendra4424'),
        //     'partner_id' => 2,
        //     'is_mitra' => 1,
        //     'diterima' => 1
        // ]);
        // User::create([
        //     'name' => 'Viin Reynaldo',
        //     'slug' => 'viin-reynaldo',
        //     'email' => 'viinreynaldo@gmail.com',
        //     'no_hp' => '0711442463',
        //     'ktp_sim' => '1671082711010041',
        //     'username' => 'Viin4424',
        //     'password' => bcrypt('Viin4424'),
        //     'partner_id' => 1,
        //     'is_mitra' => 1,
        //     'diterima' => 1
        // ]);
        // User::create([
        //     'name' => 'Yasha',
        //     'slug' => 'yasha',
        //     'email' => 'yasha@gmail.com',
        //     'no_hp' => '0711442464',
        //     'ktp_sim' => '1671082711010042',
        //     'username' => 'yasha4424',
        //     'password' => bcrypt('Ricky4424'),
        //     'partner_id' => 1,
        //     'is_mitra' => 1,
        //     'diterima' => 1
        // ]);
        // User::factory(30)->create();

        Partner::create([
            'name' => 'Mitra Kurir',
            'slug' => 'mitra-kurir'
        ]);
        Partner::create([
            'name' => 'Mitra Online Shop ',
            'slug' => 'mitra-online-shop'
        ]);

        Shipping::create([
            'nama' => 'Reguler',
            'harga' => 10000,
            'keterangan' => 'Reguler : Prediksi waktu besok'
        ]);
        Shipping::create([
            'nama' => 'Xpress',
            'harga' => 15000,
            'keterangan' => 'Xpress : Prediksi waktu hari yang sama (Siang/Sore)'
        ]);
        Shipping::create([
            'nama' => 'Kilat',
            'harga' => 25000,
            'keterangan' => 'Kilat : Prediksi waktu hari yang sama (1 jam setelah paket diambil kurir)'
        ]);

        Account::create([
            'user_id' => 1
        ]);
        Account::create([
            'user_id' => 2
        ]);
        Account::create([
            'user_id' => 3
        ]);
        // Account::create([
        //     'user_id' => 4
        // ]);
        // Account::create([
        //     'user_id' => 5
        // ]);
        // Account::create([
        //     'user_id' => 6
        // ]);
        // Account::create([
        //     'user_id' => 7
        // ]);
        // Account::create([
        //     'user_id' => 8
        // ]);

        // Package::create([
        //     'user_id' => 5,
        //     'shipping_id' => 1,
        //     'nama' => 'Pokeball',
        //     'slug' => 'pokeball',
        //     'jumlah' => 1,
        //     'hargapaket' => 100000,
        //     'alamat' => 'Jalan Buntu lorong sesat',
        //     'namapemohon' => 'Nadia Syafira',
        //     'telepon' => '89625125256',
        //     'namapenerima' => 'Ricky Andrean',
        //     'no_hp' => '85357723770',
        //     'keterangan' => 'Jangan dibanting'
        // ]);
        // Package::create([
        //     'user_id' => 5,
        //     'shipping_id' => 2,
        //     'nama' => 'Greatball',
        //     'slug' => 'greatball',
        //     'jumlah' => 1,
        //     'hargapaket' => 1050000,
        //     'alamat' => 'Jalan neraka lorong surga',
        //     'namapemohon' => 'Nadia Syafira',
        //     'telepon' => '89625125256',
        //     'namapenerima' => 'Ricky Andrean',
        //     'no_hp' => '85357723770',
        //     'keterangan' => 'Boleh dibanting'
        // ]);
        // Package::create([
        //     'user_id' => 5,
        //     'shipping_id' => 3,
        //     'nama' => 'Ultraball',
        //     'slug' => 'ultraball',
        //     'jumlah' => 1,
        //     'hargapaket' => 200000,
        //     'alamat' => 'Jalan kehidupan lorong kematian',
        //     'namapemohon' => 'Nadia Syafira',
        //     'telepon' => '89625125256',
        //     'namapenerima' => 'Ricky Andrean',
        //     'no_hp' => '85357723770',
        // ]);
        // Package::create([
        //     'user_id' => 5,
        //     'shipping_id' => 1,
        //     'nama' => 'Masterball',
        //     'slug' => 'masterball',
        //     'jumlah' => 1,
        //     'hargapaket' => 250000,
        //     'alamat' => 'Jalan kaya lorong miskin',
        //     'namapemohon' => 'Nadia Syafira',
        //     'telepon' => '89625125256',
        //     'namapenerima' => 'Ricky Andrean',
        //     'no_hp' => '85357723770',
        //     'keterangan' => 'Gercep dikit'
        // ]);

        // Package::factory(30)->create();

        Slide::create([
            'keterangan' => 'RAP-XPRESS'
        ]);
        // Slide::create([
        //     'keterangan' => 'PENGIRIMAN CEPAT DAN TEPAT',
        // ]);
        // Slide::create([
        //     'keterangan' => '"Your Online Business Solution"'
        // ]);
    }
}
