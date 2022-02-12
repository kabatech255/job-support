<?php

return [
  'user' => [
    'region' => env('AWS_USER_COGNITO_REGION', 'ap-northeast-1'),
    'userpoolId' => env('AWS_USER_COGNITO_POOL_ID', ''),
  ],
  'admin' => [
    'region' => env('AWS_ADMIN_COGNITO_REGION', 'ap-northeast-1'),
    'userpoolId' => env('AWS_ADMIN_COGNITO_POOL_ID', ''),
  ],
];
