Cimy Swift SMTP

This plug-in is developed starting from Swift SMTP 1.0 from Marcus Vanstone that give me the base to do these modifications and have a new great plug-in!
Basically this plug-in is for all people that have an hosting server that has the php mail function disabled and/or want to use their SMTP servers.


REQUIREMENTS:
- PHP >= 4.3.0
  for SSL and TLS support you need to have PHP compiled with openSSL support
  http://www.php.net/openssl
- WORDPRESS >= 2.0.x

INSTALLATION:
- just copy whole Cimy_Swift_SMTP subdir into your plug-in directory and activate it


Bugs or suggestions can be mailed at: cimmino.marco@gmail.com


FAQ:
Q: Mail are not sent, why?

A1: Check if all parameters are correct and check if the smtp works in another program like an email client
A2: If you are using SSL/TLS you need a PHP with openSSL support, see requirements


Q: Why I got duplicates of mails? It's clearly a Cimy Swift SMTP issue!

A: If the sender and the destination addresses are the same probably you are receiving one mail for the sender and one mail for the destination and you are thinking it's a duplicate, but it's not true and it's not "clearly a Cimy Swift SMTP issue".
For example GMail always does like that.


Q: When feature XYZ will be added?

A: I don't know, remember that this is a 100% free project so answer is "When I have time and/or when someone help me with a donation".


Q: Can I help with a donation?

A: Sure, visit the donation page or contact me via e-mail.


Q1: I have found a bug what can I do?
Q2: Something does not work as expected, why?

A: The first thing is to download the latest version of the plug-in and see if you still have the same issue.
If yes please write me an email or write a comment but give as more details as you can, like:
- Plug-in version
- WordPress version
- MYSQL version
- PHP version
- exact error that is returned (if any)

after describe what you did, what you expected and what instead the plug-in did :)
Then the MOST important thing is: DO NOT DISAPPEAR!
A lot of times I cannot reproduce the problem and I need more details, so if you don't check my answer then 80% of the times bug (if any) will NOT BE FIXED!


CHANGELOG:
v1.2.3 - 11/01/2009
- Fixed 404 error when saving options under certain broken webservers
- Renamed REAMDE file to README_OFFICIAL.txt due to WordPress Plugin Directory rules

v1.2.2 - 02/01/2009
- Added possibility to translate the plug-in
- Added Italian translation
- Fixed all HTML code, now it's XHTML 1.0 Transitional compliant
- Dropped use of "level_10" role check since is deprecated

v1.2.1 - 22/12/2008
- Changed plug-in link, we have a new home!
- Fixed subject corruption with certain languages (Chinese and Arabian included)
- General cosmetic fixes

v1.2.0 - 02/06/2008
- Completely re-written Bcc handling engine, previous one was completely broken (thanx to Eric)
- Fixed e-mail test failure if e-mail address isn't specified, now it takes blog's admin e-mail as second option
- Updated Swift Mailer to 3.3.3 (VERSION file reports 3.3.2 but packages were 3.3.3)

v1.1.2 - 11/10/2007
- Added option to choose if overwrite or not the sender with the one provided (thanx Chris for pointing it and testing)
- Code cleanup

v1.1.1 - 09/10/2007
- Added attribute escaping
- Changed input names to avoid browser auto-completion for username and password taken from another page of the same site
- Added a copy of the GPL license to the package
- Added FAQ
- Updated PHP requirements

v1.1.0 - 26/09/2007
- Added Cimy Plug-in Series support
- Updated Swift Mailer to 3.3.1

v1.0-cimy0.3.0 - 02/08/2007
- Fixed SSL and TLS connections with port 465 under PHP5 were completely broken

v1.0-cimy0.2.0 - 10/07/2007
- Fixed bad bug with PHP4, plug-in cannot even be activated (yes this require two new files)
- Added default values for server address and port: "localhost" and "25" respectively
- Better error handling

v1.0-cimy0.1.0 - 25/06/2007
- Updated Swift Mailer to 3.2.6
- Added both Swift for PHP4 and PHP5 with automatic check
- Added Sender Name and Email input to personalize the sender for all mails sent
- Reorganized a bit the interface to make it more user friendly
- Changed SMTP username and password to optional due to a lot of servers in Italy that doesn't require authentication
- Fixed port 25 wrong set server address to 'localhost'

v1.0 - 11/06/2007
- Original plug-in from Marcus Vanstone


This was the original changelog where this plug-in started from:

June 11, 2007 - Updated to Swift v3.2.5, WordPress MU compatible, Wordpress 2.2 Compatible, removed all PHP shorthand tags
Jan 28, 2007 - Fixed outdated use of $user_level variable with WordPress 2.1 compatible current_user_can() function.
Dec 17, 2006 - Fixed "Cannot redeclare class swift" Error.
Oct 29, 2006 - Fixed compatibility issue with ShiftThis Newsletter Plugin.  Added connection test to Options page.
