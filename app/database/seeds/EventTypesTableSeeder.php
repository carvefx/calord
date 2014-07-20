<?php

class EventTypesTableSeeder extends Seeder
{
  public function run()
  {
    $types = [
      ['type' => 'global', 'properties' => json_encode(['attendable' => false])],
      ['type' => 'attendable', 'properties' => json_encode(['attendable' => true])],
    ];

    DB::table('event_types')->insert($types);
  }
} 