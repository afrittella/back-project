<?php
return [
  'route_prefix' => 'admin',
  'registration_open' => true,
  'use_queue' => false,
  'user_model' => \App\User::class,
  // Menu logos
  'logo_large'   => '<b>Back</b>project',
  'logo_small' => '<b>B</b>p',
  'menus' => [
    'table' => 'menus'    
  ],
  'attachments' => [
      'table' => 'attachments',
      'max_file_size' => '2' // in Mb
  ]
];
