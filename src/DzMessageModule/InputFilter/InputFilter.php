<?php

/**
 * Fichier source pour l'InputFilter.
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
 * @package  DzMessageModule\InputFilter
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */

namespace DzMessageModule\InputFilter;

use DzMessageModule\Message\MessageInterface;
use DzMessageModule\Message\MessagePluginManager;
use DzMessageModule\Message\MessagePluginManagerAwareInterface;

use Zend\InputFilter\InputFilter as ZendInputFilter;

/**
 * Classe InputFilter.
 *
 * Classe de filtrage des données d'entrée
 * de formulaire utilisateur.
 * Etend Zend\InputFilter\InputFilter.
 * Injecte le MessagePluginManager pour pouvoir
 * afficher des messages en cas d'erreur.
 *
 * @category Source
 * @package  DzMessageModule\InputFilter
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class InputFilter extends ZendInputFilter implements MessagePluginManagerAwareInterface
{
    /**
     * Gestionnaire de messages.
     *
     * @var MessagePluginManager
     */
    protected $messages;

    /**
     * {@inheritdoc}
     */
    public function setMessagePluginManager($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessagePluginManager()
    {
        return $this->messages;
    }

    /**
     * Obtient un messsage auprès du MessagePluginManager.
     *
     * @param string $name Nom du message.
     *
     * @return MessageInterface
     */
    public function message($name)
    {
        $messages = $this->getMessagePluginManager();

        return $messages->get($name);
    }
}
