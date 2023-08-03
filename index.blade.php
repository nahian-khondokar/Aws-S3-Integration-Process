<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

function S3ImageHelpers($s3FilePath, $resizedImage): string
{
    Storage::disk('s3')->put($s3FilePath, $resizedImage);
    $s3File = Storage::disk('s3')->url($s3FilePath);

    return $s3File;
}

function imageResize($file, $width, $height): string
{
    // image resize
    $resizedImage = Image::make($file)->resize(1920, 700, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    })->encode();

    return $resizedImage;
}



// image delete form S3
Storage::disk('s3')->delete('media/slider/'.'/'.$image_name.'');


// store image to s3 aws
$file = $request->file('category_image');
$resizedImage = imageResize($file, 720, 400);
$filePath = Category::FILEPATH . $request->header('id') . '/';
$s3FilePath = $filePath . time() . rand() . '_category_image.' . $file->getClientOriginalExtension();
$s3ImageUrl = S3ImageHelpers($s3FilePath, $resizedImage);

// function call
$s3_image_url = S3ImageHelpers($s3FilePath, $resizedImage);


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
