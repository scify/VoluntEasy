#!/usr/bin/perl -w

use strict;

my $filepath = 'database/seeds';
my $userseedfile = 'UserTableSeeder.php.tmpl';
my $unitseedfile = 'UnitTableSeeder.php.tmpl';

USERSTART:

print "Enter information for initial database user.\n";
print "Name: ";
chomp (my $name = <STDIN>);
print "Email: ";
chomp (my $email = <STDIN>);
print "Password: ";
chomp (my $password = <STDIN>);
print "Address: ";
chomp (my $address = <STDIN>);
print "Telephone: ";
chomp (my $telephone = <STDIN>);

open my $userin, '<', "$filepath/$userseedfile" or die $!;
open my $userout, '>', "$filepath/UserTableSeeder.php" or die $!;

print "You entered:\nName: $name\nEmail: $email\nPassword: $password\nAddress: $address\nTelephone: $telephone\n";
print "Is this info correct (y/n)? ";

USERQUESTION:

chomp (my $answer = <STDIN>);

if ($answer =~ m/^[Y]$/i) {
	while (<$userin>) {
		s/%%USER%NAME%%/$name/g;
		s/%%USER%EMAIL%%/$email/g;
		s/%%USER%PASSWORD%%/$password/g;
		s/%%USER%ADDRESS%%/$address/g;
		s/%%USER%TELEPHONE%%/$telephone/g;
		print $userout $_;
	}
	print "Database seed file generated.\n";
} elsif ($answer =~ m/^[N]$/i) {
	print "Please enter credentials again.\n";
	goto USERSTART;
} else {
	print "Please enter a valid choice (y/n): ";
	goto USERQUESTION;
}

close $userout;

UNITSTART:

print "\n================\n";
print "Enter information for root unit creation\n";
print "Root unit description: ";
chomp (my $unitdescription = <STDIN>);
print "Root unit comments: ";
chomp (my $unitcomments = <STDIN>);

open my $unitin, '<', "$filepath/$unitseedfile" or die $!;
open my $unitout, '>', "$filepath/UnitTableSeeder.php" or die $!;

print "You entered:\nDescription: $unitdescription\nComments: $unitcomments\n";
print "Is this info correct (y/n)? ";

UNITQUESTION:

chomp (my $unitanswer = <STDIN>);

if ($unitanswer =~ m/^[Y]$/i) {
	while (<in>) {
		s/%%UNIT%DESCRIPTION%%/$unitdescription/g;
		s/%%UNIT%COMMENTS%%/$unitcomments/g;
		print $unitout $_;
	}
	print "Unit seed file generated.\n";
} elseif ($unitanswer =~ m/^[N]$/i) {
	print "Please enter unit credentials again.\n";
	goto UNITSTART;
} else {
	print "Please enter a valid choice (y,n)\n";
	foro UNITQUESTION;
}

close $unitout;
