<?php

namespace App\Factory\Util;

trait ImageGeneratorTrait
{
    private function generateBlobImage(string $text): string
    {
        $image = imagecreate(180, 180);
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        imagestring($image, 5, 10, 10, $text, $textColor);

        ob_start();
        imagepng($image);
        $blob = ob_get_clean();
        imagedestroy($image);

        return $blob;
    }
}
