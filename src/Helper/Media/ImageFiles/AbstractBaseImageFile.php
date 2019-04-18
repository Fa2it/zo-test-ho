<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 17.04.2019
 * Time: 23:40
 */

namespace App\Helper\Media\ImageFiles;

abstract class AbstractBaseImageFile
{

    abstract protected function imageCreate( string $filename ); // check if jpeg, png etc if actual image or fake image
    abstract protected function imageUpload( $image, string $image_path ):string;

    public function imageResize($image , int $new_size)
    {
        return imagescale ( $image , $new_size );
    }

}