<?php

/**
 * Fichier de source pour le plugin de contrôleur MessageModel.
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
use DzMessageModule\Message\Message as MessageClass;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;

/**
 * Plugin de contrôleur MessageModel.
 *
 * Retourne un ViewModel contenant un message
 * d'erreur personnalisé.
 *
 * @category Source
 * @package  DzMessageModule\Controller\Plugin
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class MessageModel extends AbstractPlugin
{
    /**
     * Méthode appelée lorsqu'un script tente d'appeler cet objet comme une fonction.
     *
     * @param string|MessageInterface $message  Message d'erreur.
     * @param string                  $template Chemin vers le fichier de template.
     *
     * @return void
     */
    public function __invoke($message, $template = null)
    {
        $viewModel  = new ViewModel();

        if (is_string($message)) {
            $str = $message;
            $message = new MessageClass;
            $message->setContent($str);
        }

        if (!$template) {
            $template = 'dz-message-module/partial/message.phtml';
        }

        $viewModel->setTemplate($template);
        $viewModel->setVariable('message', $message);

        return $viewModel;
    }
}
