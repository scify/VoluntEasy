<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "Οι :attribute πρέπει να ειναι αποδεκτοί.",
	"active_url"           => "Το :attribute δεν είναι έγκυρο URL.",
	"after"                => "Η :attribute πρέπει να είναι ημερομηνία μετά από την :date.",
	"alpha"                => "Το :attribute μπορεί να περιέχει μόνο γράμματα.",
	"alpha_dash"           => "Το :attribute μπορεί να περιέχει μόνο αλφαριθμητικά και παύλες.",
	"alpha_num"            => "Το :attribute μπορεί να περιέχει μόνο αλφαριθμητικά.",
	"array"                => "Το :attribute πρέπει να είναι πίνακας.",
	"before"               => "Το :attribute πρέπει να είναι ημερομηνία πρίν την :date.",
	"between"              => [
		"numeric" => "Το :attribute πρέπει να είναι μεταξύ :min και :max.",
		"file"    => "Το :attribute πρέπει να είναι μεταξύ :min και :max kilobytes.",
		"string"  => "Το :attribute πρέπει να είναι μεταξύ :min και :max χαρακτήρες.",
		"array"   => "Το :attribute πρέπει να έχει :min έως :max αντικείμενα.",
	],
	"boolean"              => "Το πεδίο :attribute μπορεί να είναι true ή false.",
	"confirmed"            => "Η επιβεβαίωση του :attribute δεν είναι σωστή.",
	"date"                 => "Η :attribute δεν είναι έγκυρη ημερομηνία.",
	"date_format"          => "Το :attribute δεν ακολουθεί το format :format.",
	"different"            => "Το :attribute και :other πρέπει να είναι διαφορετικά.",
	"digits"               => "Το :attribute πρέπει να είναι :digits ψηφία.",
	"digits_between"       => "Το :attribute πρέπει να είναι μεταξύ :min και :max ψηφίων.",
	"email"                => "Το :attribute πρέπει να είναι έγκυρη διεύθυνση email.",
	"filled"               => "Παρακαλώ συμπληρώστε το πεδίο :attribute.",
	"exists"               => "Το επιλεγμένο :attribute δεν είναι έγκυρο.",
	"image"                => "Το :attribute πρέπει να είναι εικόνα.",
	"in"                   => "Το επιλεγμένο :attribute δεν είναι έγκυρο.",
	"integer"              => "Το :attribute πρέπει να είναι ακέραιος.",
	"ip"                   => "Η :attribute πρέπει να είναι έγκυρη διεύθυνση IP.",
	"max"                  => [
		"numeric" => "Το :attribute δεν μπορεί να είναι μεγαλύτερο του :max.",
		"file"    => "Το :attribute δεν μπορεί να είναι μεγαλύτερο από :max kilobytes.",
		"string"  => "Το :attribute δεν μπορεί να είναι μεγαλύτερο από :max χαρακτήρες.",
		"array"   => "Το :attribute δεν μπορεί να είναι περισσότερα από :max αντικείμενα.",
	],
	"mimes"                => "Το :attribute πρέπει να είναι αρχείο τύπου: :values.",
	"min"                  => [
//		"numeric" => "Το :attribute πρέπει να είναι τουλάχιστον :min.",
        "numeric" => "Παρακαλώ συμπληρώστε το πεδίο.",
		"file"    => "Το :attribute πρέπει να είναι τουλάχιστον :min kilobytes.",
		"string"  => "Το :attribute πρέπει να είναι τουλάχιστον :min χαρακτήρες.",
		"array"   => "Το :attribute πρέπει να έχει τουλάχιστον :min αντικείμενα.",
	],
	"not_in"               => "Το επιλεγμένο :attribute δεν είναι έγκυρο.",
	"numeric"              => "Το :attribute πρέπει να είναι αριθμός.",
	"regex"                => "Το format του :attribute δεν είναι έγκυρο.",
	"required"             => "Παρακαλώ συμπληρώστε το πεδίο.",
	"required_if"          => "Το πεδίο :attribute είναι απαιτούμενο όταν :other is :value.",
	"required_with"        => "Το πεδίο :attribute είναι απαιτούμενο όταν :values is present.",
	"required_with_all"    => "Το πεδίο :attribute είναι απαιτούμενο όταν :values is present.",
	"required_without"     => "Το πεδίο :attribute είναι απαιτούμενο όταν :values is not present.",
	"required_without_all" => "Το πεδίο :attribute είναι απαιτούμενο όταν none of :values are present.",
	"same"                 => "Το πεδίο :attribute και :other πρέπει να είναι όμοια.",
	"size"                 => [
		"numeric" => "Το :attribute πρέπει να είναι :size.",
		"file"    => "Το :attribute πρέπει να είναι :size kilobytes.",
		"string"  => "Το :attribute πρέπει να είναι :size χαρακτήρες.",
		"array"   => "Το :attribute πρέπει να περιέχει τουλάχιστον :size items.",
	],
	"unique"               => "Το :attribute χρησιμοποείται ήδη.",
	"url"                  => "Το format του :attribute δεν είναι έγκυρο.",
	"timezone"             => "Η :attribute πρέπει να είναι έγκυρη ζώνη.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [

		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
