<?php
return [
  'route_prefix' => 'admin',
  'registration_open' => true,
  'redirect_after_social_login' => 'admin.dashboard', // where to redirect after successfull login
  'social_login_enabled' => [
      'facebook' => false, // enable facebook login
      'twitter' => false, // enable twitter login
      'linkedin' => false // enable linkedin login
  ],
  'use_queue' => false,
  'user_model' => Afrittella\BackProject\Models\Auth\User::class,
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
