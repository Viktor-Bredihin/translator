<?php

namespace MyTranslationUIBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MyTranslationUIBundle extends Bundle
{
    public function getParent()
    {
        return 'JMSTranslationBundle';
    }
}
