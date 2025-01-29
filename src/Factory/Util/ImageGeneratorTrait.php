<?php

namespace App\Factory\Util;

trait ImageGeneratorTrait
{
    private function generateBase64Image(string $text): string
    {
        $image = imagecreate(180, 180);
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        imagestring($image, 5, 10, 10, $text, $textColor);

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
