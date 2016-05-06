<?php

/**
 * Project: simple-feedback-form
 * Date: 06.05.16
 * Time: 21:09
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license GPL-3.0
 * @link    http://artlark.ru/
 */

namespace Controllers;

use Models\Comment;

class Reply extends Generic
{
    const IMAGE_WIDTH  = 320;
    const IMAGE_HEIGHT = 240;

    public function indexAction()
    {
        $fileName = null;

        if (isset($_FILES['file']) && !empty($_FILES['file']['tmp_name'])) {
            $image = $_FILES['file'];

            if (!in_array($image['type'], ['image/jpeg', 'image/gif', 'image/png'])) {
                throw new \Exception('Wrong file type. Allowed types: JPG, GIF, PNG');
            }

            $fileName = $this->saveImage($image['tmp_name']);
        }

        $data          = $_POST;
        $data['image'] = $fileName;

        $comment = new Comment;
        $comment->create($data);

        header('Location: /');
    }

    public function saveImage($image)
    {
        list($imageWidth, $imageHeight, $imageMime) = getimagesize($image);

        switch ($imageMime) {
            case IMAGETYPE_GIF:
                $gdImage = imagecreatefromgif($image);
                break;
            case IMAGETYPE_JPEG:
                $gdImage = imagecreatefromjpeg($image);
                break;
            case IMAGETYPE_PNG:
                $gdImage = imagecreatefrompng($image);
                break;
            default:
                $gdImage = false;
                break;
        }

        if ($gdImage === false) {
            return false;
        }

        $sourceRatio  = $imageWidth / $imageHeight;
        $allowedRatio = self::IMAGE_WIDTH / self::IMAGE_HEIGHT;

        if ($imageWidth <= self::IMAGE_WIDTH && $imageHeight <= self::IMAGE_HEIGHT) {
            $width  = $imageWidth;
            $height = $imageHeight;
        } elseif ($allowedRatio > $sourceRatio) {
            $width  = (int)(self::IMAGE_HEIGHT * $sourceRatio);
            $height = self::IMAGE_HEIGHT;
        } else {
            $width  = self::IMAGE_WIDTH;
            $height = (int)(self::IMAGE_WIDTH / $sourceRatio);
        }

        $result = imagecreatetruecolor($width, $height);
        imagecopyresampled($result, $gdImage, 0, 0, 0, 0, $width, $height, $imageWidth, $imageHeight);

        $fileName = hash('sha256', time()) . '.jpg';

        imagejpeg($result, UPLOAD_PATH . $fileName, 90);
        imagedestroy($result);

        return $fileName;
    }
}
