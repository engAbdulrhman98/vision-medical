<?php

namespace App\Services;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryService
{
    /**
     * Initialize Cloudinary configuration dynamically.
     */
    private static function init()
    {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }

    /**
     * Upload a file to Cloudinary.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string Secure URL of the uploaded asset
     */
    public static function upload($file, $folder = 'products')
    {
        self::init();

        $uploadApi = new UploadApi();
        $response = $uploadApi->upload($file->getRealPath(), [
            'folder' => $folder,
            'resource_type' => 'auto', // Automatically handles images, videos, etc.
        ]);

        return $response['secure_url'];
    }

    /**
     * Delete an asset from Cloudinary using its secure URL.
     *
     * @param string $url
     * @return void
     */
    public static function delete($url)
    {
        if (empty($url) || !str_contains($url, 'res.cloudinary.com')) {
            return;
        }

        try {
            self::init();

            // Parse public ID from Cloudinary URL
            $path = parse_url($url, PHP_URL_PATH);
            $parts = explode('/', trim($path, '/'));

            // Index of "upload"
            $uploadIndex = array_search('upload', $parts);
            if ($uploadIndex !== false) {
                $startIndex = $uploadIndex + 1;
                
                // Skip version code if present (starts with 'v' followed by numbers)
                if (isset($parts[$startIndex]) && str_starts_with($parts[$startIndex], 'v') && is_numeric(substr($parts[$startIndex], 1))) {
                    $startIndex++;
                }

                $remainingParts = array_slice($parts, $startIndex);
                $publicIdWithExtension = implode('/', $remainingParts);
                
                // Remove file extension
                $publicId = pathinfo($publicIdWithExtension, PATHINFO_FILENAME);

                // Detect resource type (image or video) from URL segments
                $resourceType = 'image';
                if (in_array('video', $parts)) {
                    $resourceType = 'video';
                }

                $uploadApi = new UploadApi();
                $uploadApi->destroy($publicId, [
                    'resource_type' => $resourceType
                ]);
            }
        } catch (\Exception $e) {
            logger()->error('Cloudinary asset deletion failed: ' . $e->getMessage());
        }
    }
}
