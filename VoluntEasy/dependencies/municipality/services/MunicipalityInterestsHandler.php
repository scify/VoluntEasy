<?php namespace dependencies\municipality\services;

class MunicipalityInterestsHandler {

    public function orderInterests($interestCategories) {
        /**
         * Παιδί
        Καθαριότητα
        Πολιτισμός
        Περιβάλλον
        Υγεία
        Δημόσιος Χώρος
        Κοινωνική Αλληλεγγύη
        Αθλητισμός
        Τουρισμός
         */
        $tempInterests = array();
        foreach($interestCategories[0]->interests as $interest) {
            array_push($tempInterests, $interest);
        }
        $interestCategories[0]->interests[0] = $tempInterests[6];
        $interestCategories[0]->interests[1] = $tempInterests[4];
        $interestCategories[0]->interests[2] = $tempInterests[2];
        $interestCategories[0]->interests[3] = $tempInterests[7];
        $interestCategories[0]->interests[4] = $tempInterests[0];
        $interestCategories[0]->interests[5] = $tempInterests[5];
        $interestCategories[0]->interests[6] = $tempInterests[3];
        $interestCategories[0]->interests[7] = $tempInterests[1];
        $interestCategories[0]->interests[8] = $tempInterests[8];
//        array_splice($interestCategories[0]->interests, 4, 0, $interestCategories[0]->interests[0]);
//        dd($interestCategories[0]->interests);
        return $interestCategories;
    }

}
