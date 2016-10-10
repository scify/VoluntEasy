<?php namespace dependencies\municipality\services;

class MunicipalityLanguagesHandler {

    public function formatLanguagesArray($languages) {
        $temp = array();
        foreach ($languages as $language) {
            $temp[$language->id] = $language->description;
        }
        return $temp;
    }
}
