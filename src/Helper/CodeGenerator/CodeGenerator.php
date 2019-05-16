<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 25.04.2019
 * Time: 19:58
 */

namespace App\Helper\CodeGenerator;


class CodeGenerator
{

     public function random_string(string  $input='',  int $strength = 5): string
     {
         if( empty($input) ){
             $input = str_shuffle('123456789ABCDEFGHIJKLMNPQRSTUVWXYZ');
         }

         $input_length = strlen($input);
         $random_string = '';
         for($i = 0; $i < $strength; $i++) {
             $random_character = $input[mt_rand(0, $input_length - 1)];
             $random_string .= $random_character;
         }

         return $random_string;
     }



     public function emailEncode( string $email ):string
     {
         return base64_encode ( $this->random_string().base64_encode ( base64_encode ( trim( $email ) ) ).$this->random_string() );
     }


    public function emailDecode( string $en_str ):string
    {
        return base64_decode( base64_decode( substr( substr( base64_decode ( trim( $en_str ) ), 0, -5 ), 5 )  ) );
    }


}