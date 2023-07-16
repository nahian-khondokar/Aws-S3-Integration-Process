<?php

use Illuminate\Support\Facades\Storage;

function S3ImageHelpers($file_path, $file=null, $fileName){

    // Image upload to AWS S3
    Storage::disk('s3')->putFileAs($file_path, $file, $fileName);
    $fileUrl = Storage::disk('s3')->url($file_path . $fileName);

    return $fileUrl;

}


// image delete form S3
Storage::disk('s3')->delete('media/slider/'.'/'.$image_name.'');


// store image to s3 aws
$file_path = 'media/slider/'.$request->header('id').'/';
$mainImageName = time() . '_slider_image.' . $photo->getClientOriginalExtension();

// function call
$s3_image_url = S3ImageHelpers($file_path, $photo, $mainImageName);


// =========== Notes =========
// --> Aws time zone & you device time should be same. othewise it shows error.
// --> We need to add AWS configuration in .env file, like below
            // AWS_ACCESS_KEY_ID=AKIAWKHZEG4VWBBDYTL3
            // AWS_SECRET_ACCESS_KEY=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
            // AWS_DEFAULT_REGION=ap-southeast-1
            // AWS_BUCKET=funnelliner
            // AWS_URL=https://funnelliner.s3.ap-southeast-1.amazonaws.com
            // AWS_USE_PATH_STYLE_ENDPOINT=false

            // FILESYSTEM_DISK=s3

// --> filesystems.php configeration 
        // 's3' => [
        //         'driver' => 's3',
        //         'key'   => env('AWS_ACCESS_KEY_ID'),
        //         'secret' => env('AWS_SECRET_ACCESS_KEY'),
        //         'region' => env('AWS_DEFAULT_REGION'),
        //         'bucket' => env('AWS_BUCKET'),
        //         'url'    => env('AWS_URL'),
        //         'endpoint' => env('AWS_ENDPOINT'),
        //         'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        //     ],     