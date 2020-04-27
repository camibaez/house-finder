<?php
namespace common\components\extractor;

class LocationsExtractor extends DataExtractor{
    /**
     * 
     * @param string $data
     * @param \common\models\House $model
     */
    public function extract($data, $model) {
        $province = $this->extractProvince($data);
        $model->province_id = $province;
        
        $municipality = $this->extractMunicipality($data, $provinceId);
        $model->municipality_id = $municipality;
    }

   
    
    public function extractProvince($data) {
        $provinces = \Yii::$app->params['provinces-data'];
        
        $provinceId = null;
        foreach ($provinces as $province){
            $id = $province['id'];
            $matcher = $province['matcher'];
            
            $isPreg = substr($matcher, 0, 1) == '/';
            if($isPreg)
                $match = preg_match($matcher, $data);
            else
                $match = strstr($data, $matcher);
            if($match){
                $provinceId = $id;           
                break;
            }
        }
        return $provinceId;
    }
    
    
    public function extractMunicipality($data, $provinceId) {
        $municipalities = null;
        $municipalityId = null;
        
        foreach ($municipalities as $municipality){
            $id = $municipality['id'];
            $matcher = $municipality['matcher'];
            
            $isPreg = substr($matcher, 0, 1) == '/';
            if($isPreg)
                $match = strstr ($data, $matcher);
        }
    }
}
