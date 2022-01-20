<?php

return [
  'region' => env('AWS_COGNITO_REGION', 'ap-northeast-1a'),
  'userpoolId' => env('AWS_COGNITO_USER_POOL_ID', ''),
];
