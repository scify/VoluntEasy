<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User as User;

class VolunteerTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run()
    {
	    // Identification types.
	    DB::table('identification_types')->delete();

	    $types = [
		    ['description' => 'Α.Δ.Τ.'],
		    ['description' => 'Διαβατήριο'],
		    ['description' => 'Άδεια παραμονής'],
	    ];

	    DB::table('identification_types')->insert($types);

	    // Marital statuses.
	    DB::table('marital_statuses')->delete();

	    $statuses = [
		    ['description' => 'Άγαμος/η'],
		    ['description' => 'Παντρεμένος/η'],
		    ['description' => 'Χήρος/α'],
		    ['description' => 'Διαζευγμένος/η'],
	    ];

	    DB::table('marital_statuses')->insert($statuses);

	    // Driver license types.
	    DB::table('driver_license_types')->delete();

	    $license_types = [
		    ['description' => 'Χωρίς δίπλωμα'],
		    ['description' => 'Α κατηγορίας'],
		    ['description' => 'A1 κατηγορίας'],
		    ['description' => 'Β κατηγορίας'],
		    ['description' => 'Γ κατηγορίας'],
		    ['description' => 'Γ+Ε κατηγορίας'],
	    ];

	    DB::table('driver_license_types')->insert($license_types);

	    // Availability frequency messages.
	    DB::table('availability_freqs')->delete();

	    $frequencies = [
		    ['description' => '1-2 φορές την εβδομάδα'],
		    ['description' => '1-2 φορές το δεκαπενθήμερο'],
		    ['description' => '1-2 φορές τον μήνα'],
	    ];

	    DB::table('availability_freqs')->insert($frequencies);

	    // Work status messages.
	    DB::table('work_statuses')->delete();

	    $statuses = [
		    ['description' => 'Φοιτητής'],
		    ['description' => 'Εργαζόμενος'],
		    ['description' => 'Άνεργος'],
		    ['description' => 'Συνταξιούχος'],
	    ];

	    DB::table('work_statuses')->insert($statuses);

	    // Availability time.
	    DB::table('availability_time')->delete();

	    $availability = [
		    ['description' => 'Πρωί'],
		    ['description' => 'Μεσημέρι'],
		    ['description' => 'Απόγευμα'],
	    ];

	    DB::table('availability_time')->insert($availability);

        // Interest categories.
        DB::table('interest_categories')->delete();

        /*
        $interest_categories = [
            ['description' => 'Πολιτισμός και Αθλητισμός'],
            ['description' => 'Για το Παιδί'],
            ['description' => 'Περιβάλλον'],
            ['description' => 'Διεύθυνση Κοινωνικής Αλληλεγγύης και Υγείας'],
        ];
        */

        //ekpizo
        $interest_categories = [
            ['description' => 'Γενικά ενδιαφέροντα'],
        ];
        DB::table('interest_categories')->insert($interest_categories);


	    // Volunteer interests.
	    DB::table('interests')->delete();

        $cat_general = \App\Models\Descriptions\InterestCategory::where('description', 'Γενικά ενδιαφέροντα')->first()->id;

        $interests = [
            ['category_id' => $cat_general, 'description' => 'Διεξαγωγή ερευνών'],
            ['category_id' => $cat_general, 'description' => 'Νομική υποστήριξη καταναλωτών'],
            ['category_id' => $cat_general, 'description' => 'Μεταφράσεις'],
            ['category_id' => $cat_general, 'description' => 'Κειμενογράφηση'],
            ['category_id' => $cat_general, 'description' => 'Γραφιστικά'],
            ['category_id' => $cat_general, 'description' => 'Οργάνωση Εκδηλώσεων'],
            ['category_id' => $cat_general, 'description' => 'Επικοινωνία/Social media'],
        ];


        /*
        $cat_politismos = \App\Models\Descriptions\InterestCategory::where('description', 'Πολιτισμός και Αθλητισμός')->first()->id;
        $cat_paidi = \App\Models\Descriptions\InterestCategory::where('description', 'Για το Παιδί')->first()->id;
        $cat_perivallon = \App\Models\Descriptions\InterestCategory::where('description', 'Περιβάλλον')->first()->id;
        $cat_ygeia = \App\Models\Descriptions\InterestCategory::where('description', 'Διεύθυνση Κοινωνικής Αλληλεγγύης και Υγείας')->first()->id;
        */
        /*
	    $interests = [
            ['category_id' => $cat_politismos, 'description' => 'Πολιτιστικά προγράμματα'],
            ['category_id' => $cat_politismos, 'description' => 'Αθλητικά προγράμματα'],
            ['category_id' => $cat_politismos, 'description' => 'Προγράμματα δημιουργικής έκφρασης παιδιών και ενηλίκων'],

            ['category_id' => $cat_paidi, 'description' => 'Κοινωνικό Φροντιστήριο'],
            ['category_id' => $cat_paidi, 'description' => 'Απογευματινές Δράσεις σε Σχολεία'],

            ['category_id' => $cat_perivallon, 'description' => 'Ενημέρωση/ευαισθητοποίηση πολιτών σε περιβαλλοντικά θέματα'],
            ['category_id' => $cat_perivallon, 'description' => 'Καθαρισμός δημοσίου χώρου'],
            ['category_id' => $cat_perivallon, 'description' => 'Βάψιμο επιφανειών'],
            ['category_id' => $cat_perivallon, 'description' => 'Antigraffiti'],
            ['category_id' => $cat_perivallon, 'description' => 'Δεντροφύτευση'],

		    ['category_id' => $cat_ygeia,  'description' => 'Λέσχες Φιλίας'],
		    ['category_id' => $cat_ygeia,  'description' => 'Δημοτικά ιατρεία'],
		    ['category_id' => $cat_ygeia,  'description' => 'Κοινωνική εργασία'],
		    ['category_id' => $cat_ygeia,  'description' => 'Δομές αντιμετώπισης της Φτώχειας'],
		    ['category_id' => $cat_ygeia,  'description' => 'Κέντρο Υποδοχής και Αλληλεγγύης Δήμου Αθηναίων (ΚΥΑΔΑ)'],
		    ['category_id' => $cat_ygeia,  'description' => 'Καταπολέμηση εξαρτήσεων'],
		    ['category_id' => $cat_ygeia,  'description' => 'Κοινωνική κατοικία'],
		    ['category_id' => $cat_ygeia,  'description' => 'Αμέα'],
		    ['category_id' => $cat_ygeia,  'description' => 'Ισότητα των φύλων'],
		    ['category_id' => $cat_ygeia,  'description' => 'Μετανάστες/Πρόσφυγες'],
		    ['category_id' => $cat_ygeia,  'description' => 'Επιδοματική Πολιτική – Κοινωνική Ασφάλιση'],
		    ['category_id' => $cat_ygeia,  'description' => 'Οργάνωση & Λειτουργία'],
	    ];
        */
	    DB::table('interests')->insert($interests);

	    // Genders.
	    DB::table('genders')->delete();

	    $genders = [
		    ['description' => 'Άνδρας'],
		    ['description' => 'Γυναίκα'],
	    ];

	    DB::table('genders')->insert($genders);

	    // Language list.
	    DB::table('languages')->delete();

	    $languages = [
		    ['description' => 'Ελληνικά'],
		    ['description' => 'Αγγλικά'],
		    ['description' => 'Γαλλικά'],
		    ['description' => 'Ισπανικά'],
		    ['description' => 'Γερμανικά'],
	    ];

	    DB::table('languages')->insert($languages);

	    // Education levels.
	    DB::table('education_levels')->delete();

	    $ed_levels = [
		    ['description' => 'Γυμνάσιο'],
		    ['description' => 'Λύκειο'],
		    ['description' => 'Ανώτερη'],
		    ['description' => 'Ανώτατη'],
		    ['description' => 'Μεταπτυχιακά'],
	    ];

	    DB::table('education_levels')->insert($ed_levels);

	    // Communication method.
	    DB::table('comm_method')->delete();

	    $comm_choice = [
		    ['description' => 'Ηλεκτρονικό ταχυδρομείο'],
		    ['description' => 'Τηλέφωνο οικίας'],
		    ['description' => 'Τηλέφωνο εργασίας'],
		    ['description' => 'Κινητό τηλέφωνο'],
	    ];

	    DB::table('comm_method')->insert($comm_choice);

	    // Language levels.
	    DB::table('language_levels')->delete();

	    $levels = [
		    ['description' => 'Βασικό'],
		    ['description' => 'Καλό'],
		    ['description' => 'Πολύ καλό'],
	    ];

	    DB::table('language_levels')->insert($levels);

	    // // Seed template.
	    DB::table('volunteer_statuses')->delete();

        $statuses = [
	             ['id' => 1, 'description' => 'Pending'],
	             ['id' => 2, 'description' => 'Available'],
	             ['id' => 3, 'description' => 'Active'],
	             ['id' => 4, 'description' => 'Not available'],
	             ['id' => 5, 'description' => 'Blacklisted'],
	     ];

	     DB::table('volunteer_statuses')->insert($statuses);

        // // Seed template.
        DB::table('step_statuses')->delete();

        $statuses = [
            ['description' => 'Complete'],
            ['description' => 'Incomplete'],
        ];

        DB::table('step_statuses')->insert($statuses);
    }

}
