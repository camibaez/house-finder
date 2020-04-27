<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;

/**
 * Description of ImagesPool
 *
 * @author User
 */
class ImagesPool {
   static public $imagesId = [];
   
   public static function adId($id){
       self::$imagesId []= $id;
   }
   

}
