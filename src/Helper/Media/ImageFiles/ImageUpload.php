<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 18.04.2019
 * Time: 01:28
 */

namespace App\Helper\Media\ImageFiles;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUpload
{
    const _DEFAULT_IMAGE_FOLDER = "../public/media/";
    const _DEFAULT_MAX_SIZE = 500;

    private $image_upload_dir;
    private $max_image_size;
    private $resize_value;
    private $file_name;


    public function upload( $files, array $fileOptions =[] ): array
    {

        $arr_files = $uploaded_file_names = [];
        if( !is_array( $files ) ){ $arr_files[] = $files;  }
        foreach ($arr_files as $file ){
            $uploaded_file_names[] = $this->processUploadedFiles( $file, $fileOptions);
        }
        return $uploaded_file_names;
    }

    public function removeImage( string $imageName ){
        if( $imageName ) {
            if ( file_exists($this->getImageUploadDir() . $imageName) ) {
                unlink($this->getImageUploadDir() . $imageName);
                return ["Success"=>"image removed"];
            }
            return ["Error"=>"image doesn't exist"];
        }
        return ["Error"=>"image Name is Empty"];
    }


    private function processUploadedFiles(UploadedFile $uploadedFile , array $fileOptions ){
        // Base on type we get the file to be manipulates.
        $error_msg =[];
        if(  $uploadedFile->getSize() < $this->getMaxImageSize() ){

            if( $imageFile = $this->imageFactory( trim( $uploadedFile->guessExtension()  ) ) ){
                $img_res = $imageFile->imageCreate( $uploadedFile->getRealPath() );

                if( !empty( $this->getResizeValue() ) ){

                    $img_res = $imageFile->imageResize( $img_res, $this->getResizeValue() );
                }
                return $imageFile->imageUpload($img_res, $this->getImageUploadDir() . $this->getFileName() );
            }
            return $error_msg['ERROR'][ 'NO_FILE_TYPE_FOUND'];
        }
        $error_msg['ERROR'][ 'MAX_SIZE_EXCEEDED'] = ["image_size" =>$uploadedFile->getSize(), "Max_size"=> $this->getMaxImageSize() ];
        return $error_msg;

    }

    /**
     * @return mixed
     */
    public function getImageUploadDir()
    {
        return self::_DEFAULT_IMAGE_FOLDER.$this->image_upload_dir;
    }

    /**
     * @param mixed $image_upload_dir
     */
    public function setImageUploadDir($image_upload_dir): void
    {
        $this->image_upload_dir = $image_upload_dir;
    }

    /**
     * @return mixed
     */
    public function getMaxImageSize()
    {
        if( empty( $this->max_image_size ) )
                return self::_DEFAULT_MAX_SIZE * 1024;

        return $this->max_image_size;
    }

    /**
     * @param mixed $max_image_size
     */
    public function setMaxImageSize($max_image_size): void
    {
        $this->max_image_size = $max_image_size;
    }

    /**
     * @return mixed
     */
    public function getResizeValue()
    {
        return $this->resize_value;
    }

    /**
     * @param mixed $resize_value
     */
    public function setResizeValue($resize_value): void
    {
        $this->resize_value = $resize_value;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        if( empty($this->file_name) )
            return $this->randomFileNames( 3 );
        return $this->file_name;
    }

    /**
     * @param mixed $file_name
     */
    public function setFileName($file_name): void
    {
        $this->file_name = $file_name;
    }


    private function imageFactory( string $image_type ){

        switch ($image_type) {
            case 'jpeg':
            case 'jpg' : /* @var \App\Helper\Media\ImageFiles\JpegImageFile */
                return new JpegImageFile();
            default:
                return null;
        }
    }

    public function randomFileNames(int $str_len = 1  ): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $str_len; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString.uniqid().rand(11,99);
    }

}