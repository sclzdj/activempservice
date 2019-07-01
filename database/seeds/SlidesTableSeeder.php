<?php

use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $slides = factory(\App\Model\Active\Slide::class, 5)->create();
        /*$slide = $slides[0];
        $slide->title = '';
        $slide->pic = '';
        $slide->event_id = 0;
        $slide->save();*/
    }
}
