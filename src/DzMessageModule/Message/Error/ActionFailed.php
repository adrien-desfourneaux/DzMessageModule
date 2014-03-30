<?php

/**
 * Fichier source pour le message d'erreur d'une action échouée.
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
 * Classe de message d'une action échouée.
 *
 * PHP version 5.3.0
 *
 * @category Source
 * @package  DzMessageModule\Message
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class ActionFailed extends ErrorMessage
{
    /**
     * Constructeur de ActionFailed.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->createArgument('action');

        $this->setContent("L'action" . $this->mark('action') . "a échouée.");
    }
}
