<?php

/**
 * Fichier source pour le MessageFactory.
 *
 * Copyright 2014 Adrien Desfourneaux
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzMessageModule\Controller\Plugin\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */

namespace DzMessageModule\Controller\Plugin\Factory;

use DzMessageModule\Controller\Plugin\Message;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe MessageFactory.
 *
 * Classe usine pour le plugin de contrôleur message.
 *
 * @category Source
 * @package  DzMessageModule\Controller\Plugin\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class MessageFactory implements FactoryInterface
{
    /**
     * Cré et retourne un plugin de contrôleur message.
     *
     * @param ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return Message
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $plugin = new Message;

        $locator  = $serviceLocator->getServiceLocator();
        $messages = $locator->get('DzMessageModule\MessageManager');

        $plugin->setMessagePluginManager($messages);

        return $plugin;
    }
}
