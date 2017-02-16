# OpenACH Origination Platform

OpenACH is a free, open-source, secure web-based ACH origination and 
payment processing platform.  For more information, visit 
[openach.com](http://openach.com/)


## OVERVIEW

OpenACH is tested and runs on a Linux/Apache/PHP stack, with either 
Postgresql or SQLite as a database backend.  It is built on the [Yii
1.0 framework](https://github.com/yiisoft/yii), so installation is
similar to a standard Yii 1.0 app.

The release contains the following directories:

      assets/              auto-published CSS and Javascript assets
      css/                 global CSS files
      images/              global images
      js/                  global js files
      legal/               license information
      protected/           the core application, on the Yii framework
      themes/              the OpenACH Yii theme
      yii                  a symbolic link to the latest Yii 1.0 framework
      index.php            the main entry point for the framework
      README.md            this file
      UPGRADE              upgrading instructions


## REQUIREMENTS

The minimum requirement for OpenACH is that your Web server supports
PHP 5.3, and has been tested on PHP 5.5.  Ubuntu 12.04 LTS and 
Ubuntu 14.04 LTS make great platforms for running an OpenACH
system.


## QUICK START

### Docker
[Docker](http://docker.io) is a platform for developers and sysadmins 
to develop, ship, and run applications. Docker lets you quickly 
assemble applications from components and eliminates the friction that 
can come when shipping code. Docker lets you get your code tested and 
deployed into production as fast as possible.

Docker can run on a wide variety of platforms. Visit the 
[Docker.io](http://docker.io) website to learn how to install Docker 
on your system. NOTE: To most easily access the OpenACH command line 
interface (CLI), you will need Docker 1.3 or higher.

To get started using the Docker OpenACH image, see the instructions 
here: [OpenACH Docker Image](https://github.com/openach/docker-openach

### The OpenACH CLI
OpenACH comes with a command line tool, based on the "yiic" CLI, which
you can use to perform nearly all the admin functions.  See the 
[OpenACH CLI Documentation](http://openach.com/books/openach-cli-documentation/openach-cli-documentation) 
for more information.


The OpenACH Developer Team
http://openach.com
# OpenACH Origination Platform

OpenACH is a free, open-source, secure web-based ACH origination and 
payment processing platform.  For more information, visit 
[openach.com](http://openach.com/)

## REQUIREMENTS

The minimum requirement for OpenACH is that your Web server supports
PHP 5.3, and has been tested on PHP 5.5.  Ubuntu 12.04 LTS and 
Ubuntu 14.04 LTS make great platforms for running an OpenACH
system.

## QUICK START

### Docker
[Docker](http://docker.io) is a platform for developers and sysadmins 
to develop, ship, and run applications. Docker lets you quickly 
assemble applications from components and eliminates the friction that 
can come when shipping code. Docker lets you get your code tested and 
deployed into production as fast as possible.

Docker can run on a wide variety of platforms. Visit the 
[Docker.io](http://docker.io) website to learn how to install Docker 
on your system. NOTE: To most easily access the OpenACH command line 
interface (CLI), you will need Docker 1.3 or higher.

To get started using the Docker OpenACH image, see the instructions 
here: [OpenACH Docker Image](https://github.com/openach/docker-openach)

### Install From Source
You can install OpenACH from this source repository.

#### Clone this repository
```
   git clone https://github.com/openach/openach.git
   cd openach
```

#### Set up a Database
OpenACH supports SQLite and Postgres.

##### SQLite
The OpenACH code base ships with a clean, pre-initialized SQLite database.  To use it, simply copy it to the protected/runtime/db/ folder.
```
   cp protected/data/openach.db.init_save protected/runtime/db/openach.db
```
Then edit protected/config/db.php, uncommenting the SQLite section and updating the connection string to reflect the FULL PATH to the protected/runtime/db/openach.db data file.

##### Postgres
Create a new postgres database, and initialize it with:
```
   psql -d YOUR_DATABASE_NAME -a -f protected/data/schema.postgresql.sql
   psql -d YOUR_DATABASE_NAME -a -f protected/data/data.postgresql.sql
```
Then edit protected/config/db.php to reflect your database credentials.

#### Set Your Encryption Key
All sensitive information within the OpenACH database is encrypted using an application-wide encryption key.  It should be updated by editing protected/config/security.php.  Note that once you begin using a database with a given encryption key, the data becomes useless without it.  As such, you will want to back up your key in a safe place.

#### Set Up Your Web Server
OpenACH is tested on Apache, but could also work on Nginx with the proper configuration.  We have included a sample Apache config file to get you started.  See the example in protected/data/etc/apache2/sites-available/openach.

We highly recommend setting up an SSL certificate to protect all communications with your web server.  There are plenty of guides on how to do this available elsewhere, so we won't go into detail here.

Your DocumentRoot should point to the root folder of your OpenACH install (where the index.php lives).

#### Set File Permissions
Insure that the entire protected/runtime/ folder is accessible by your web server process owner.  Typically this can be accomplished with:

```
   chown -R www-data:www-data protected/runtime/
```
The user/group name may vary based on your Linux distribution.

#### Almost There!
You are almost ready to go.  Refer to the CLI documentation below for additional steps needed to set up an origination account and configure your bank plugin.

### The OpenACH CLI
OpenACH comes with a command line tool, based on the "yiic" CLI, which
you can use to perform nearly all the admin functions.  See the 
[OpenACH CLI Documentation](http://openach.com/books/openach-cli-documentation/openach-cli-documentation) 
for more information.


The OpenACH Developer Team
http://openach.com
