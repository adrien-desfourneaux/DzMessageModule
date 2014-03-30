<?php

/**
 * Fichier de source pour le plugin de contrôleur MessageException.
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
use DzMessageModule\Exception\MessageException as TrueMessageException;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;

/**
 * Plugin de contrôleur MessageException.
 *
 * Retourne une exception, instance de
 * DzMessageModule\Exception\MessageException,
 * contenant un message d'erreur personnalisé.
 *
 * @category Source
 * @package  DzMessageModule\Controller\Plugin
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class MessageException extends AbstractPlugin
{
    /**
     * Renderer pour le plugin.
     *
     * @var RendererInterface
     */
    protected $renderer;

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
        $converter = new MessageModel;
        $renderer  = $this->getRenderer();

        $viewModel = $converter($message, $template);
        $result    = $renderer->render($viewModel);

        $exception = new TrueMessageException($result);

        return $exception;
    }

    /**
     * Définit le renderer pour le plugin.
     *
     * @param RendererInterface $renderer Nouveau renderer.
     *
     * @return MessageException
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;

        return $this;
    }

    /**
     * Obtient le renderer pour le plugin.
     *
     * @return RendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }
}
