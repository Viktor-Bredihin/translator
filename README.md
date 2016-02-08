in-gym

TECHNICAL REQUIREMENTS
========================

* git  
* composer  
* php >= 5.3.3  

GIT REPO BRANCHES
========================

* master - main work branch

TECHNOLOGIES
========================

## Back-end

* php

* symfony

* mysql

## Front-end

* js

* jQuery

* Compass

* Twitter Bootstrap

* gulp

## SYMFONY 2 BUNDLES

* JMSTranslationBundle

* JMSI18nRoutingBundle

* JMSDiExtraBundle

* JMSAopBundle


Useful commands
========================

* gulp (track changes)

* gulp build (build assets)

* php app/console fos:js-routing:dump (build fos_js_routes.js)

DEPLOYMENT INSTRUCTIONS
========================

### Clone the repo 

    $ git clone

### Install vendors & configure parameters

    $ composer install

### Install npm modules

* npm install

### Install bower components

* bower install

### Change the permissions of the next directories so that the web server can write into them:

    app/cache/
    app/logs/    
    web/media/
    web/uploads/

> the ways to do it are described [here](http://symfony.com/doc/master/book/installation.html#configuration-and-setup) 

    $ sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs web/media web/uploads web/media
    $ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs web/media web/uploads web/media

### Install assets

    $ php app/console assets:install web --symlink

    $ php app/console assetic:dump --env=prod

## Create configured databases

    $ php app/console doctrine:database:create
    $ php app/console doctrine:schema:update --force

## Load fixtures:

ORM fixtures:

    $ php app/console doctrine:fixtures:load 

## Check against requirements to run the application:

In web browser run:  
    
    /check.php

    /check-ims.php
