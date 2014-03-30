<?php

/**
 * Fichier source pour le FieldValueTooLong.
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
 * @package  DzMessageModule\Message\Error
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */

namespace DzMessageModule\Message\Error;

/**
 * Classe de message d'erreur FieldValueTooLong.
 *
 * Message d'erreur quand le contenu d'un champ de formulaire
 * est trop long.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzMessageModule\Message\Error
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class FieldValueTooLong extends FieldError
{
    /**
     * Constructeur de FieldValueTooLong.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->createArgument('maxLength');

        // ', il ne doit pas dépasser '_'200 caractères'_'.'
        //$this->setMaxLength('200 caractères', ', il ne doit pas dépasser', '.');

        $this->setContent("La valeur du champ" . $this->mark('field') . "est trop longue" . $this->mark('maxLength'));
    }
}
