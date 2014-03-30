<?php

/**
 * Fichier source pour l'interface ArgumentInterface.
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


/**
 * Interface ArgumentInterface.
 *
 * Interface pour un argument de message.
 *
 * @category Source
 * @package  DzMessageModule\Message
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
interface ArgumentInterface
{
    /**
     * Définit le préfixe.
     *
     * @param string $prefix Nouveau péfixe.
     *
     * @return ArgumentInterface
     */
    public function setPrefix($prefix);

    /**
     * Obtient le préfixe.
     *
     * @return string
     */
    public function getPrefix();

    /**
     * Définit le contenu.
     *
     * @param string $content Nouveau contenu.
     *
     * @return ArgumentInterface
     */
    public function setContent($content);

    /**
     * Obtient le contenu.
     *
     * @return string
     */
    public function getContent();

    /**
     * Définit le suffixe.
     *
     * @param string $suffix Nouveau suffixe.
     *
     * @return ArgumentInterface
     */
    public function setSuffix($suffix);

    /**
     * Obtient le suffixe.
     *
     * @return string
     */
    public function getSuffix();

    /**
     * Conversion de l'Argument en chaîne
     * de caractères.
     *
     * @return string
     */
    public function toString();

    /**
     * Comportement dans un contexte de chaîne
     * de caractères.
     *
     * @return string
     */
    public function __toString();
}
