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

	    DB::table('marital_statuses')->insert($types);

	    // Driver license types.
	    DB::table('driver_license_types')->delete();

	    $license_types = [
		    ['description' => 'Χωρίς δίπλωμα'],
		    ['description' => 'Α κατηγορίας'],
		    ['description' => 'A1 κατηγορίας'],
		    ['description' => 'B κατηγορίας'],
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
		    ['work_status' => 'Φοιτητής'],
		    ['work_status' => 'Εργαζόμενος'],
		    ['work_status' => 'Άνεργος'],
		    ['work_status' => 'Συνταξιούχος'],
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

	    // Volunteer interests.
	    DB::table('interests')->delete();

	    $interests = [
		    ['category' => 'Γενική κατηγορία', 'description' => 'Πολιτισμός και εκπαίδευση'],
		    ['category' => 'Γενική κατηγορία', 'description' => 'Αθλητισμός'],
		    ['category' => 'Περιβάλλον', 'description' => 'Ενημέρωση/ευαισθητοποίηση πολιτών σε περιβαλλοντικά θέματα'],
		    ['category' => 'Περιβάλλον', 'description' => 'Καθαρισμός δημοσίου χώρου'],
		    ['category' => 'Περιβάλλον', 'description' => 'Βάψιμο επιφανειών'],
		    ['category' => 'Περιβάλλον', 'description' => 'Antigraffiti'],
		    ['category' => 'Περιβάλλον', 'description' => 'Δεντροφύτευση'],
		    ['category' => 'Κοινωνική αλληλεγγύη', 'description' => 'Κόμβος αλληλεγγύης πολιτών'],
		    ['category' => 'Κοινωνική αλληλεγγύη', 'description' => 'Παροχή φροντίδας ως εθελοντής γείτονας'],
	    ];

	    DB::table('interests')->insert($interests);

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

	    // Language levels.
	    DB::table('language_levels')->delete();

	    $levels = [
		    ['description' => 'Βασικό'],
		    ['description' => 'Καλό'],
		    ['description' => 'Πολύ καλό'],
	    ];

	    DB::table('language_levels')->insert($levels);

	    // // Seed template.
	    // DB::table('')->delete();

	    // $statuses = [
	    //         ['description' => ''],
	    //         ['description' => ''],
	    //         ['description' => ''],
	    //         ['description' => ''],
	    // ];

	    // DB::table('')->insert($types);
    }

}
