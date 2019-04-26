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
             $input = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
         }

         $input_length = strlen($input);
         $random_string = '';
         for($i = 0; $i < $strength; $i++) {
             $random_character = $input[mt_rand(0, $input_length - 1)];
             $random_string .= $random_character;
         }

         return $random_string;
     }
}