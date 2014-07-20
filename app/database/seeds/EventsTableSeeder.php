<?php

use \Carbon\Carbon;
class EventsTableSeeder extends Seeder
{
  public function run()
  {
    $events = [
      [
        'date_time' => Carbon::now(),
        'event_type_id' => 1,
        'title' => 'My first meeting',
        'description' => 'This is my first meeting. It\'s gonna be awesome.',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ],
      [
        'date_time' => Carbon::yesterday(),
        'event_type_id' => 1,
        'title' => 'Another example meeting',
        'description' => 'This is an example meeting. It\'s gonna be awesome.',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ],
      [
        'date_time' => Carbon::now()->addWeek(),
        'event_type_id' => 1,
        'title' => 'Another example meeting',
        'description' => 'This is an example meeting. It\'s gonna be awesome.',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ],
    ];
    DB::table('events')->insert($events);
  }
} 