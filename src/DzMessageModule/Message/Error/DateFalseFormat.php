<?php

/**
 * Fichier source pour le DateFalseFormat.
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
 * Classe de message d'erreur DateFalseFormat.
 *
 * Message d'erreur quand une date n'est
 * pas dans un bon format de date.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzMessageModule\Message\Error
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class DateFalseFormat extends ErrorMessage
{
    /**
     * Constructeur de DateFalseFormat.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->createArgument('format');
        $this->setFormat('jj/mm/aaaa', ', doit être ');

        $this->setContent('Format de date invalide' . $this->mark('format'));
    }
}
