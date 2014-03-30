<?php

/**
 * Fichier source pour le MessagePluginManager.
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

use DzMessageModule\Exception\InvalidMessageException;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Classe MessagePluginManager.
 *
 * Gestionnaire de messages. Cette classe étend AbstractPluginManager
 * pour avoir le même comportement qu'un ServiceManager.
 *
 * @category Source
 * @package  DzMessageModule\Message
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class MessagePluginManager extends AbstractPluginManager
{
    /**
     * Usines par défaut pour les messages.
     *
     * @var array
     */
    protected $factories = array();

    /**
     * Invokables par défaut pour les messages.
     *
     * Ici tous les caractères des clés sont en minuscule.
     * C'est par ce que le ServiceManager, intérieurement,
     * stocke toutes les clés en minuscule.
     *
     * @var array
     */
    protected $invokableClasses = array(
        'dzmessagemoduleactionfailed'      => 'DzMessageModule\Message\Error\ActionFailed',
        'dzmessagemoduledatefalseformat'   => 'DzMessageModule\Message\Error\DateFalseFormat',
        'dzmessagemoduledeletefailed'      => 'DzMessageModule\Message\Error\DeleteFailed',
        'dzmessagemoduleelementnotfound'   => 'DzMessageModule\Message\Error\ElementNotFound',
        'dzbasemoudleelementsnotfound'     => 'DzMessageModule\Message\Error\ElementsNotFound',
        'dzmessagemoduleerrormessage'      => 'DzMessageModule\Message\Error\ErrorMessage',
        'dzmessagemodulefieldvalueempty'   => 'DzMessageModule\Message\Error\FieldValueEmpty',
        'dzmessagemodulefieldvaluetoolong' => 'DzMessageModule\Message\Error\FieldValueTooLong',
        'dzmessagemodulemessage'           => 'dzmessagemodule\Message\Message',
    );

    /**
     * Alias par défaut pour les messages.
     *
     * @var array
     */
    protected $aliases = array(
        'actionfailed'      => 'dzmessagemoduleactionfailed',
        'datefalseformat'   => 'dzmessagemoduledatefalseformat',
        'deletefailed'      => 'dzmessagemoduledeletefailed',
        'elementnotfound'   => 'dzmessagemoduleelementnotfound',
        'elementsnotfound'  => 'dzmessagemoduleelementsnotfound',
        'errormessage'      => 'dzmessagemoduleerrormessage',
        'fieldvalueempty'   => 'dzmessagemodulefieldvalueempty',
        'fieldvaluetoolong' => 'dzmessagemodulefieldvaluetoolong',
        'message'           => 'dzmessagemodulemessage',
    );

    /**
     * Valide un plugin.
     *
     * Vérifie que le message chargé est une instance de MessageInterface.
     *
     * @param mixed $plugin Plugin à valider.
     *
     * @return void
     *
     * @throws InvalidMessageException Si le plugin est invalide.
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof MessageInterface) {
            return;
        }

        throw new InvalidMessageException(sprintf(
            'Le plugin de type %s est invalide; il doit implémenter %s\MessageInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}
