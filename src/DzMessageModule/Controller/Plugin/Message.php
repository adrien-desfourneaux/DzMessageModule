<?php

/**
 * Fichier de source pour le plugin de contrôleur Message.
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
 * @package  DzMessageModule\Controller\Plugin
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */

namespace DzMessageModule\Controller\Plugin;

use DzMessageModule\Message\MessageInterface;
use DzMessageModule\Message\MessagePluginManager;
use DzMessageModule\Message\MessagePluginManagerAwareInterface;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Plugin de contrôleur Message.
 *
 * Obtient un message auprès du gestionnaire de messages.
 *
 * @category Source
 * @package  DzMessageModule\Controller\Plugin
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class Message extends AbstractPlugin implements MessagePluginManagerAwareInterface
{
    /**
     * Gestionnaire de messages.
     *
     * @var MessagePluginManager
     */
    protected $messages;

    /**
     * Méthode appelée lorsqu'un script tente
     * d'appeler cet objet comme une fonction.
     *
     * @param string $name Nom du message à récupérer.
     *
     * @return Message|MessageInterface
     */
    public function __invoke($name = null)
    {
        if ($name) {
            $messages = $this->getMessagePluginManager();

            return $messages->get($name);
        } else {
            return $this;
        }
    }

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
}
