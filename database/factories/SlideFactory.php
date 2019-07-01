<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Active\Slide::class, function (Faker $faker) {
    return [
      'title' =>  $faker->text(50),
      'pic'      => 'http://15233xe404.iask.in/saimgs/'.mt_rand(1,10).'.png',
      'event_id' => mt_rand(1, 10),
    ];
}
);
