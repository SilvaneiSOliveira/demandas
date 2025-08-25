<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UfSeeder extends Seeder
{
    public function run(): void
    {
        $ufs = [
            ['uf' => 'AC'],
            ['uf' => 'AL'],
            ['uf' => 'AP'],
            ['uf' => 'AM'],
            ['uf' => 'BA'],
            ['uf' => 'CE'],
            ['uf' => 'DF'],
            ['uf' => 'ES'],
            ['uf' => 'GO'],
            ['uf' => 'MA'],
            ['uf' => 'MT'],
            ['uf' => 'MS'],
            ['uf' => 'MG'],
            ['uf' => 'PA'],
            ['uf' => 'PB'],
            ['uf' => 'PR'],
            ['uf' => 'PE'],
            ['uf' => 'PI'],
            ['uf' => 'RJ'],
            ['uf' => 'RN'],
            ['uf' => 'RS'],
            ['uf' => 'RO'],
            ['uf' => 'RR'],
            ['uf' => 'SC'],
            ['uf' => 'SP'],
            ['uf' => 'SE'],
            ['uf' => 'TO'],
        ];

        DB::table('ufs')->insert($ufs);
    }
}