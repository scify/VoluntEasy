#!/usr/bin/perl -w

use strict;

my $filepath = 'database/seeds';
my $seedfile = 'UserTableSeeder.php.tmpl';

START:

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

open my $in, '<', "$filepath/$seedfile" or die $!;
open my $out, '>', "$filepath/UserTableSeeder.php" or die $!;

print "You entered:\nName: $name\nEmail: $email\nPassword: $password\nAddress: $address\nTelephone: $telephone\n";
print "Is this info correct (y/n)? ";

QUESTION:

chomp (my $answer = <STDIN>);

if ($answer =~ m/^[Y]$/i) {
	while (<$in>) {
		s/%%USER%NAME%%/$name/g;
		s/%%USER%EMAIL%%/$email/g;
		s/%%USER%PASSWORD%%/$password/g;
		s/%%USER%ADDRESS%%/$address/g;
		s/%%USER%TELEPHONE%%/$telephone/g;
		print $out $_;
	}
	print "Database seed file generated.\n";
} elsif ($answer =~ m/^[N]$/i) {
	print "Please enter credentials again.\n";
	goto START;
} else {
	print "Please enter a valid choice (y/n): ";
	goto QUESTION;
}

close $out;
