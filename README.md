translation
===========

1) Installed JMSTranslationBundle/JMSI18nRoutingBundle/JMSDiExtraBundle/JMSAopBundle for translates
2) Installed FosUserBundle (we need to have users to check access for Translation - WebUI)
    a) create super admin
        php app/console fos:user:create admin admin@gmail.com admin --super-admin
    b) create user
        php app/console fos:user:create user user@gmail.com user
