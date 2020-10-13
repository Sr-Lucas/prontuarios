<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpertiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doctor_expertises')->insert([
            'name' => 'Alergia e Imunologia',
            'description' => 'diagnóstico e tratamento das doenças alérgicas e do sistema imunológico.',
        ]);

        DB::table('doctor_expertises')->insert([
            'name' => 'Anestesologia',
            'description' => 'área da Medicina que envolve o tratamento da dor, a hipnose e o manejo intensivo do paciente sob intervenção cirúrgica ou procedimentos.',
        ]);

        DB::table('doctor_expertises')->insert([
            'name' => 'Angiologia',
            'description' => 'é a área da medicina que estuda o tratamento das doenças do aparelho circulatório.',
        ]);

        DB::table('doctor_expertises')->insert([
            'name' => 'Cancerologia',
            'description' => 'é a especialidade que trata dos tumores malignos ou câncer.',
        ]);
    }
}
