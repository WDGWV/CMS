#!/usr/bin/perl
use POSIX;
# Use POSIX (Portable Operating System Interface),
# a set of standard operating system interfaces.
$ENV{'TZ'} = "GMT";
# Set the Time Zone to GMT (Greenwich Mean Time) for date calculations.
for ($clock = 2147483641; $clock < 2147483651; $clock++)
{
    print ctime($clock);
}
# Count up in seconds of Epoch time just before and after the critical event.
# Print out the corresponding date in Gregorian calendar for each result.
# Are the date and time outputs correct after the critical event second?