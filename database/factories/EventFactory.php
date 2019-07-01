<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Active\Event::class, function (Faker $faker) {
    return [
      'title'    => $faker->text(50),
      'describe' => $faker->text(100),
      'pic'      => 'http://15233xe404.iask.in/saimgs/'.mt_rand(1,10).'.png',
      'content'  => $faker->randomHtml(),
      'pv'       => $faker->numberBetween(0, 10000),
      'created_at'=>$faker->dateTime()
    ];
}
);
