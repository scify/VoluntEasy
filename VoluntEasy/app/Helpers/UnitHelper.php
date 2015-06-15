<?php namespace App\Helpers;

class UnitHelper {

    private $units;

    public function __construct($units) {
        $this->units = $units;
    }

    public function htmlList() {
        return $this->htmlFromArray($this->unitArray());
    }

    private function unitArray() {
        $result = array();
        foreach($this->units as $unit) {
            if ($unit->parent_id == 0) {
                $result[$unit->name] = $this->unitWithChildren($unit);
            }
        }
        return $result;
    }

    private function childrenOf($unit) {
        $result = array();
        foreach($this->units as $i) {
            if ($i->parent_id == $unit->id) {
                $result[] = $i;
            }
        }
        return $result;
    }

    private function unitWithChildren($unit) {
        $result = array();
        $children = $this->childrenOf($unit);
        foreach ($children as $child) {
            $result[$child->name] = $this->unitWithChildren($child);
        }
        return $result;
    }

    private function htmlFromArray($array) {
        $html = '';
        foreach($array as $k=>$v) {
            $html .= "<ul>";
            $html .= "<li>".$k."</li>";
            if(count($v) > 0) {
                $html .= $this->htmlFromArray($v);
            }
            $html .= "</ul>";
        }
        return $html;
    }
}