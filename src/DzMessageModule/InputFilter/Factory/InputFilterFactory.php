<?php

/**
 * Fichier source pour le InputFilterFactory.
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
 * @package  DzMessageModule\InputFilter\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */

namespace DzMessageModule\InputFilter\Factory;

use DzMessageModule\InputFilter\InputFilter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe InputFilterFactory.
 *
 * Classe usine pour un InputFilter qui peut
 * obtenir des messages auprès du MessageManager.
 *
 * @category Source
 * @package  DzMessageModule\Controller\Plugin\Factory
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class InputFilterFactory implements FactoryInterface
{
    /**
     * Cré et retourne un InputFilter.
     *
     * @param ServiceLocatorInterface $serviceLocator Localisateur de service.
     *
     * @return InputFilter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $filter = new InputFilter;

        $this->injectDependencies($filter, $serviceLocator);
        $filter->init();

        return $filter;
    }

    /**
     * Injecte les dépendances de l'InputFilter.
     *
     * Injecte le MessageManager pour pouvoir
     * afficher des messages d'erreur depuis le
     * MessageManager.
     *
     * @param InputFilter             $filter         Filtre d'inputs.
     * @param ServiceLocatorInterface $serviceLocator Localisateur de services.
     *
     * @return void
     */
    public function injectDependencies($filter, $serviceLocator)
    {
        $locator = $serviceLocator->getServiceLocator();

        $messages = $locator->get('DzMessageModule\MessageManager');

        $filter->setMessagePluginManager($messages);
    }
}
