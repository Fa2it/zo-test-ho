<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 18.04.2019
 * Time: 00:44
 */

namespace App\Helper\Media\ImageFiles;
use App\Helper\Media\ImageFiles\resource;

class JpegImageFile extends AbstractBaseImageFile
{

    public function imageCreate( string $filename )
    {
        return imageCreateFromJpeg( $filename );
    }

    public function imageUpload( $image , string $target_file ): string
    {
        if( strpos ( $target_file , '.jpeg' )  !== false ){

         } else { $target_file = $target_file.'.jpeg'; }

        if ( ! file_exists( $target_file ) ) {
            imagejpeg( $image, $target_file );
            imagedestroy($image);
            $file_name = explode('/',$target_file );
            return $file_name[ count($file_name) -1 ];
        }
        return '';
    }

}