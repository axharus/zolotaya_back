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
        $faker = Faker\Factory::create();

        $limit = 80;
        $sections = [4,5,6];
        $insection = [1,2,3,4];
        $cat = [17,18,19,20,21,22,23,24,25,26,27];
        $color = [11,28,29,30,31];
        $size = [12,13,14,15,16];

        for ($i = 0; $i < $limit; $i++) {
            DB::table('product')->insert([ //,
                'name_ru' => $faker->sentence(4),
                'name_ua' => $faker->sentence(4),
                'section' => $sections[$faker->numberBetween(0,count($sections)-1)],
                'insection' => $this->randformArray(0, $insection),
                'cat'   => $cat[$faker->numberBetween(0,count($cat)-1)],
                'price' => $faker->numberBetween(0,2200),
                'bprice'    => $faker->numberBetween(0,3200),
                'color' => $this->randformArray(1, $color),
                'size' => $this->randformArray(1, $size),
                'gallery'   => '["PerxDOzPpXmeJdldDQ.jpg", "CwkXutz7mSjNCgKwuD.jpg", "hMoAUrYRLBdqPfcljc.jpg", "cvMs5yeLZ1geXVxCwL.jpg"]',
                'data'  => '[{"num": "1", "name_ru": "1", "name_ua": "2", "value_ru": "3", "value_ua": "4"}]',
                'vendor'    => $faker->secondaryAddress(),
                'keywords'  => $faker->words(20, true),
                'description'   => $faker->sentence(18),
                'created_at'    => $faker->time("U"),
                'updated_at'    => $faker->time("U")
            ]);
        }

    }

    private function randformArray($min, $data){
        $faker = Faker\Factory::create();
        $out = [];
        for ($i = $faker->numberBetween($min, count($data)); $i--;){
            $rand = $faker->numberBetween(0, count($data)-1);
            while (in_array($data[$rand],$out)){
                $rand = $faker->numberBetween(0, count($data)-1);
            }
            $out[] = json_encode($data[$rand]);
        }
        return json_encode($out);
    }
}
