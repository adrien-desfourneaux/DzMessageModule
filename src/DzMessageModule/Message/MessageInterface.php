<?php

/**
 * Fichier source pour l'interface MessageInterface.
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
 * @package  DzMessageModule\Message
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */

namespace DzMessageModule\Message;

use Zend\Stdlib\MessageInterface as ZendMessageInterface;

/**
 * Interface pour les messages du module DzMessageModule.
 *
 * Etend Zend\Stdlib\MessageInterface.
 *
 * @category Source
 * @package  DzMessageModule\Message
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
interface MessageInterface extends ZendMessageInterface
{
    /**
     * Cré un argument.
     *
     * @param string $name Nom de l'argument à créer.
     *
     * @return void
     */
    public function createArgument($name);

    /**
     * Convertit le nom d'argument en marqueur.
     *
     * @param string $name Nom de l'argument.
     *
     * @return string
     */
    public function mark($name);

    /**
     * Convertit le marqueur en nom d'argument.
     *
     * @param string $mark Marqueur.
     *
     * @return string
     */
    public function unmark($mark);

    /**
     * Définit un argument.
     *
     * Les arguments (instances de ArgumentInterface) sont stockés
     * dans les metadata de Zend\Stdlib\Message.
     *
     * @param string $name     Nom de l'argument.
     * @param mixed  $argument Argument ou contenu (content) de l'Argument.
     * @param string $prefix   Préfixe de l'argument (optionnel, non déclaré).
     * @param string $suffix   Suffixe de l'argument (optionnel, non déclaré).
     *
     * @return Message
     */
    public function __setArgument($name, $argument);

    /**
     * Obtient un argument.
     *
     * @param string $name Nom de l'argument.
     *
     * @return ArgumentInterface
     */
    public function __getArgument($name);

    /**
     * Méthode magique __call.
     *
     * Regarde les clés des metadata.
     *
     * Si la méthode appelée correspond à
     * set{$key} alors appeler setArgument($name, $args).
     *
     * Si la méthode appelée correspond à
     * get{$key} alors appeler getArgument($name).
     *
     * @param string $name      Nom de la méthode appelée.
     * @param array  $arguments Arguments de la méthode.
     *
     * @return ArgumentInterface|Message|mixed
     */
    public function __call($name, $arguments);
}
