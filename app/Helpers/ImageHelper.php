<?php

namespace App\Helpers;

use Exception;

class ImageHelper {
    public static function upload($file) {
            if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
                throw new \Exception("Uploaded file is not valid");
            }

            $image = $file['tmp_name'];

            list($width, $height) = getimagesize($image);
            $maxSize = 800;

            if ($width > $maxSize || $height > $maxSize) {
                $ratio = min($maxSize / $width, $maxSize / $height);
                $newWidth = $width * $ratio;
                $newHeight = $height * $ratio;

                $src = imagecreatefromstring(file_get_contents($image));
                $dst = imagecreatetruecolor($newWidth, $newHeight);

                imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                ob_start();
                imagejpeg($dst);
                $imageData = ob_get_clean();

                imagedestroy($src);
                imagedestroy($dst);
            } else {
                $imageData = file_get_contents($image);
            }

            return $imageData;
    }


    public static function processImage($file) {
        $maxWidth = 800;
        $maxHeight = 800;

        $imageInfo = getimagesize($file['tmp_name']);
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $imageType = $imageInfo[2];

        if ($imageType === IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($file['tmp_name']);
        } elseif ($imageType === IMAGETYPE_PNG) {
            $image = imagecreatefrompng($file['tmp_name']);
        } else {
            throw new Exception('Unsupported image type');
        }

        $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
        $newWidth = round($originalWidth * $ratio);
        $newHeight = round($originalHeight * $ratio);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        $fileName = uniqid() . '.jpg';

        $rootDirectory = dirname(__DIR__, 2);
        $filePath = $rootDirectory . '/storage/images/' . $fileName;

        if (!file_exists($rootDirectory . '/storage/images')) {
            mkdir($rootDirectory . '/storage/images', 0777, true);
        }

        imagejpeg($newImage, $filePath, 90);

        imagedestroy($image);
        imagedestroy($newImage);

        return $filePath;
    }

    /**
     * @param string $filename
     * @param int $max_size
     * @return string
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function resize(string $filename, int $max_size = 700)
    {
        /** check what kind of file type it is **/
        $type = mime_content_type($filename);

        if (file_exists($filename)) {
            switch ($type) {

                case 'image/png':
                    $image = imagecreatefrompng($filename);
                    break;

                case 'image/gif':
                    $image = imagecreatefromgif($filename);
                    break;

                case 'image/jpeg':
                    $image = imagecreatefromjpeg($filename);
                    break;

                case 'image/webp':
                    $image = imagecreatefromwebp($filename);
                    break;

                default:
                    return $filename;
                    break;
            }

            $src_w = imagesx($image);
            $src_h = imagesy($image);

            if ($src_w > $src_h) {
                //reduce max size if image is smaller
                if ($src_w < $max_size) {
                    $max_size = $src_w;
                }

                $dst_w = $max_size;
                $dst_h = ($src_h / $src_w) * $max_size;
            } else {

                //reduce max size if image is smaller
                if ($src_h < $max_size) {
                    $max_size = $src_h;
                }

                $dst_w = ($src_w / $src_h) * $max_size;
                $dst_h = $max_size;
            }

            $dst_w = round($dst_w);
            $dst_h = round($dst_h);

            $dst_image = imagecreatetruecolor($dst_w, $dst_h);

            if ($type == 'image/png') {

                imagealphablending($dst_image, false);
                imagesavealpha($dst_image, true);
            }

            imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

            imagedestroy($image);

            switch ($type) {

                case 'image/png':
                    imagepng($dst_image, $filename, 8);
                    break;

                case 'image/gif':
                    imagegif($dst_image, $filename);
                    break;

                case 'image/jpeg':
                    imagejpeg($dst_image, $filename, 90);
                    break;

                case 'image/webp':
                    imagewebp($dst_image, $filename, 90);
                    break;

                default:
                    imagejpeg($dst_image, $filename, 90);
                    break;
            }

            imagedestroy($dst_image);
        }

        return $filename;
    }


    /**
     * @param string $filename
     * @param int $max_width
     * @param int $max_height
     * @return string
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function crop(string $filename, int $max_width = 700, int $max_height = 700)
    {
        /** check what kind of file type it is **/
        $type = mime_content_type($filename);

        if (file_exists($filename)) {
            $imagefunc = 'imagecreatefromjpeg';

            switch ($type) {

                case 'image/png':
                    $image = imagecreatefrompng($filename);
                    $imagefunc = 'imagecreatefrompng';
                    break;

                case 'image/gif':
                    $image = imagecreatefromgif($filename);
                    $imagefunc = 'imagecreatefromgif';
                    break;

                case 'image/jpeg':
                    $image = imagecreatefromjpeg($filename);
                    $imagefunc = 'imagecreatefromjpeg';
                    break;

                case 'image/webp':
                    $image = imagecreatefromwebp($filename);
                    $imagefunc = 'imagecreatefromwebp';
                    break;

                default:
                    return $filename;
                    break;
            }

            $src_w = imagesx($image);
            $src_h = imagesy($image);

            if ($max_width > $max_height) {
                if ($src_w > $src_h) {
                    $max = $max_width;
                } else {
                    $max = ($src_h / $src_w) * $max_width;
                }
            } else {
                if ($src_w > $src_h) {
                    $max = ($src_w / $src_h) * $max_height;
                } else {
                    $max = $max_height;
                }
            }

            $this->resize($filename, $max);

            $image = $imagefunc($filename);

            $src_w = imagesx($image);
            $src_h = imagesy($image);

            $src_x = 0;
            $src_y = 0;
            if ($max_width > $max_height) {
                $src_y = round(($src_h - $max_height) / 2);
            } else {
                $src_x = round(($src_w - $max_width) / 2);
            }

            $dst_image = imagecreatetruecolor($max_width, $max_height);

            if ($type == 'image/png') {
                imagealphablending($dst_image, false);
                imagesavealpha($dst_image, true);
            }

            imagecopyresampled($dst_image, $image, 0, 0, $src_x, $src_y, $max_width, $max_height, $max_width, $max_height);
            imagedestroy($image);

            switch ($type) {
                case 'image/png':
                    imagepng($dst_image, $filename, 8);
                    break;

                case 'image/gif':
                    imagegif($dst_image, $filename);
                    break;

                case 'image/jpeg':
                    imagejpeg($dst_image, $filename, 90);
                    break;

                case 'image/webp':
                    imagewebp($dst_image, $filename, 90);
                    break;

                default:
                    imagejpeg($dst_image, $filename, 90);
                    break;
            }

            imagedestroy($dst_image);
        }

        return $filename;
    }


    /**
     * @param string $filename
     * @param int $max_width
     * @param int $max_height
     * @return array|string|string[]|null
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function getThumbnail(string $filename, int $max_width = 700, int $max_height = 700)
    {
        if (file_exists($filename)) {
            $ext = explode(".", $filename);
            $ext = end($ext);

            $dest = preg_replace("/\.{$ext}$/", '_thumbnail.' . $ext, $filename);

            if (file_exists($dest)) {
                return $dest;
            }

            copy($filename, $dest);
            $this->crop($dest, $max_width, $max_height);

            $filename = $dest;
        }

        return $filename;
    }
}
