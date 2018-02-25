# directv_channel_changer
A tool to remotely change channels on a set of DirecTV tuners

I created this tool because I needed to provide users with a method of changing channels on a set of remotely-located DirecTV tuners.  It may be useful to those controlling a number of DirecTV tuners, such as bars and restaurants, or enterprise environments.

This was developed on Raspbian, running on a Raspberry Pi.

The scanfortuners.php script, if run from the command line, will scan your local subnets for DirecTV tuners, and add them to the sqlite database.  It is possible to manually add a tuner to the database if it is not in your local subnet.

The tuners can be given names in the database, which tell the user which box they are controlling.

The software I am running:
Raspbian Stretch
Apache/2.4.25
PHP Version 7.0.27-0+deb9u1
