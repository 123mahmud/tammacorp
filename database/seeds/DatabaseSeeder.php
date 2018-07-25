<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(GajiManajemenTableSeeder::class);
        $this->call(GajiProduksiTableSeeder::class);
        $this->call(JabatanProTableSeeder::class);
        $this->call(DivisiTableSeeder::class);
        $this->call(SubDivisiTableSeeder::class);
        $this->call(ShiftTableSeeder::class);
        $this->call(TugasTableSeeder::class);
    }
}
