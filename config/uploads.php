<?php

/*
|--------------------------------------------------------------------------
| Where uploaded images are saved
|--------------------------------------------------------------------------
|
| LOCAL  : leave both values empty in .env.
|          Files go to  storage/app/public  (run "php artisan storage:link")
|          and are shown from  http://127.0.0.1:8000/storage/...
|
| LIVE   : set both values in the server's .env
|          UPLOAD_PATH=/home/CPANEL_USER/public_html/project_name/uploads
|          UPLOAD_URL=https://yourdomain.com/project_name/uploads
|          (no "storage:link" needed)
|
| The database only stores the short path (for example "sliders/abc.jpg"),
| so the same data works in both places.
*/

return [
    'path' => env('UPLOAD_PATH'),
    'url'  => env('UPLOAD_URL'),
];
