<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace MyTranslationUIBundle\Controller;

use JMS\TranslationBundle\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use JMS\TranslationBundle\Translation\XliffMessageUpdater;
use JMS\TranslationBundle\Util\FileUtils;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api")
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ApiController
{
    /** @DI\Inject("jms_translation.config_factory") */
    private $configFactory;

    /** @DI\Inject */
    private $request;

    /** @DI\Inject("jms_translation.updater") */
    private $updater;

    /**
     * @Route("/configs/{config}/domains/{domain}/locales/{locale}/messages",
     *          name="jms_translation_create_message",
     *          options = {"i18n" = false})
     * @Method("POST")
     */
    public function createMessageAction(Request $request, $config, $domain, $locale)
    {
        $config = $this->configFactory->getConfig($config, $locale);

        $files = FileUtils::findTranslationFiles($config->getTranslationsDir());
        if (!isset($files[$domain][$locale])) {
            throw new RuntimeException(sprintf('There is no translation file for domain "%s" and locale "%s".', $domain, $locale));
        }

        list($format, $file) = $files[$domain][$locale];

        $this->updater->createTranslation(
            $file, $format, $domain, $locale, $this->request->request->get('key'),
            $this->request->request->get('message')
        );

        return new Response();
    }

    /**
     * @Route("/configs/{config}/domains/{domain}/locales/{locale}/messages",
     *          name="jms_translation_delete_message",
     *          defaults = {"id" = null},
     *          options = {"i18n" = false})
     * @Method("DELETE")
     */
    public function deleteMessageAction(Request $request, $config, $domain, $locale)
    {
        $id = $request->query->get('id');

        $config = $this->configFactory->getConfig($config, $locale);

        $files = FileUtils::findTranslationFiles($config->getTranslationsDir());
        if (!isset($files[$domain][$locale])) {
            throw new RuntimeException(sprintf('There is no translation file for domain "%s" and locale "%s".', $domain, $locale));
        }

        list($format, $file) = $files[$domain][$locale];

        $this->updater->deleteTranslation(
            $file, $format, $domain, $locale, $id,
            $this->request->request->get('message')
        );

        return new Response();
    }
}
