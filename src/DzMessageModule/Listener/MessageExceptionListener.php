<?php

/**
 * Fichier de source pour le MessageExceptionListener.
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
 * @package  DzMessageModule\Listener
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */

namespace DzMessageModule\Listener;

use DzMessageModule\Exception\MessageException;
use DzMessageModule\Message\Message;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

/**
 * Classe MessageExceptionListener.
 *
 * @category Source
 * @package  DzMessageModule\Listener
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class MessageExceptionListener extends AbstractListenerAggregate
{
    /**
     * Attache un ou plusieurs écouteurs.
     *
     * @param EventManagerInterface $eventManager Instance de EventManager
     *
     * @return void
     */
    public function attach(EventManagerInterface $eventManager)
    {
        $this->listeners[] = $eventManager->attach(
            MvcEvent::EVENT_RENDER_ERROR,
            array(
                $this,
                'catchMessageException'
            ), 100
        );
    }

    /**
     * Attrape les exceptions de type
     * \DzMessageModule\Exception\MessageException
     * avant l'ExceptionStrategy par défaut.
     *
     * @param EventInterface $event Evénement.
     *
     * @return void
     */
    public function catchMessageException(EventInterface $event)
    {
        $exception = $event->getParam('exception');

        if ($exception && $exception instanceof MessageException) {
            $message = $exception->getMessage();

            $model = new ViewModel();
            $model->setVariable('message', $message);
            $model->setTemplate('dz-message-module/error/message.phtml');

            $event->setResult($model);
            $event->setError(false);
        }
    }
}
