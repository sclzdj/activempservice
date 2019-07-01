<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $events = factory(\App\Model\Active\Event::class, 20)->create();
        /*$event = $events[0];
        $event->title = '';
        $event->describe = '';
        $event->pic = '';
        $event->content = '';
        $event->pv = 0;
        $event->save();*/
    }
}


