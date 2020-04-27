<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components\extractor;

/**
 * Description of ExtractorController
 *
 * @author User
 */
class ExtractorController {
    public $webExtractors = [];
    public $dataExtractors = [];
    
    public function __construct() {
        $this->dataExtractors [] = new LocationsExtractor();
    }
    
    public function extractData(){
        foreach ($this->webExtractors as $webExtractor) {
            while ($data = $webExtractor->extract()){
                $model = new \common\models\House();
                foreach($this->dataExtractors as $extractor) {
                  $extractor->extract($data, $model);
                }
            }
        }  
    }
}
