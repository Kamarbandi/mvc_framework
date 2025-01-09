<?php


namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * Class Image
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
class Image
{
    /**
     * Resize an image to the specified max size while maintaining aspect ratio.
     *
     * @param string $filename
     * @param int $max_size
     * @return string
     */
    public function resize(string $filename, int $max_size = 700): string
    {
        if (!file_exists($filename)) {
            return $filename;
        }

        $type = mime_content_type($filename);
        $image = $this->createImageFromType($filename, $type);

        if (!$image) {
            return $filename;
        }

        [$src_w, $src_h] = [imagesx($image), imagesy($image)];
        [$dst_w, $dst_h] = $this->calculateDimensions($src_w, $src_h, $max_size);

        $dst_image = imagecreatetruecolor($dst_w, $dst_h);
        if ($type === 'image/png') {
            imagealphablending($dst_image, false);
            imagesavealpha($dst_image, true);
        }

        imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
        imagedestroy($image);

        $this->saveImage($dst_image, $filename, $type);
        imagedestroy($dst_image);

        return $filename;
    }

    /**
     * Create an image resource based on its mime type.
     *
     * @param string $filename
     * @param string $type
     * @return resource|false
     */
    private function createImageFromType(string $filename, string $type)
    {
        return match ($type) {
            'image/png' => imagecreatefrompng($filename),
            'image/gif' => imagecreatefromgif($filename),
            'image/jpeg' => imagecreatefromjpeg($filename),
            'image/webp' => imagecreatefromwebp($filename),
            default => false,
        };
    }

    /**
     * Calculate the new image dimensions while maintaining the aspect ratio.
     *
     * @param int $src_w
     * @param int $src_h
     * @param int $max_size
     * @return array
     */
    private function calculateDimensions(int $src_w, int $src_h, int $max_size): array
    {
        if ($src_w > $src_h) {
            $max_size = min($src_w, $max_size);
            $dst_w = $max_size;
            $dst_h = ($src_h / $src_w) * $max_size;
        } else {
            $max_size = min($src_h, $max_size);
            $dst_w = ($src_w / $src_h) * $max_size;
            $dst_h = $max_size;
        }

        return [round($dst_w), round($dst_h)];
    }

    /**
     * Save the image based on its mime type.
     *
     * @param resource $image
     * @param string $filename
     * @param string $type
     * @return void
     */
    private function saveImage($image, string $filename, string $type): void
    {
        match ($type) {
            'image/png' => imagepng($image, $filename, 8),
            'image/gif' => imagegif($image, $filename),
            'image/jpeg' => imagejpeg($image, $filename, 90),
            'image/webp' => imagewebp($image, $filename, 90),
            default => imagejpeg($image, $filename, 90),
        };
    }
}
