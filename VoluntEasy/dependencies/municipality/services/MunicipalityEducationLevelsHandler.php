<?php namespace dependencies\municipality\services;

class MunicipalityEducationLevelsHandler{

    public function sortEducationLevelsArray($edLevel) {
        $tempDescription = $edLevel[sizeof($edLevel) - 1]['description'];
        $tempId = $edLevel[sizeof($edLevel) - 1]['id'];
        array_splice($edLevel, 0, 0, $tempDescription);
        $edLevel[0] = array('id' => $tempId, 'description' => $tempDescription);
        array_pop($edLevel);
        $tempDescription = $edLevel[sizeof($edLevel) - 1]['description'];
        $tempId = $edLevel[sizeof($edLevel) - 1]['id'];
        array_splice($edLevel, 3, 0, $tempDescription);
        $edLevel[3] = array('id' => $tempId, 'description' => $tempDescription);
        array_pop($edLevel);
        return $edLevel;
    }

    public function makeSingleArrayFromEducationLevelsNestedArray($edLevel) {
        $temp = array();
        foreach ($edLevel as $key => $value) {
            $temp[$value['id']] = $value['description'];
        }
        return $temp;
    }
}
