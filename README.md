POSSA QueueCallers
==================

QueueCallers is a simple PHP Page for displaying Asterisk queue agents and callers. Initially developed by Mark Veenstra at markinthedark.nl and modifed slightly for FreePBX users.


## Compatibility
This project should install and run on PHP enabled web server with access to an Asterisk server. The project is tested and streamlined for installation on a FreePBX server running FreePBX 2.9 or later.

## Installation
* Download the latest version of the project archive from: https://github.com/POSSA/QueueCallers/releases
* decompress the archive on the server to [webroot]/queuecallers
* chown and chmod the queuecallers folder and contents as necessary
* If installing on a FreePBX 2.9 (or higher) server installation should be done. If running other versions, or a non standard install navigate to `/[webroot]/queuecallers/inc/defines.php` and edit with Asterisk server access credentials.

## Usage
* Navigate to: `[web_server_ip]/queuecallers`
* From the dropdown menus select the page refresh rate and the Asterisk queue, that's it!

## More information
Questions, feature requests, bug reports can be added to the issue tracker: https://github.com/POSSA/QueueCallers/issues




Original readme file from by Mark Veenstra <belgie@markinthedark.nl>

```
** Background
        When I search the Internet there are better and more
improved add-ons for Asterisk to list/show all callers and
members of an Asterisk queue. But most of them are too complex
or too expensive for my needs, therefore I created this simple
PHP page. Hopefully you enjoy!

** Security concerns
        This PHP page doesn't include any user authentication.
This is a feature I didn't need because I don' allow any other
people on port 80 of Apache. If you do want some kind of user
authentication, you can:
    1. Expand this PHP page with this feature (please let me
       know)
    2. Make use of a .htaccess with a .htpasswd

** Installation
  - Upload the *.tgz file to your webroot folder of you Asterisk
    server (For example: /var/www/html/).
  - Login to your Asterisk server and execute the next commands:
    cd /var/www/html/
    tar xzvf queue-list-v0.5.tgz

** Configure PHP page
  - Edit the file inc/defines.php and change the MySQL database
    settings.

** Check installation
Open your browser and point in to http://<asterisk_server>/queue_list/

** Credits
Special thanks to everyone in the Asterisk community.
```
