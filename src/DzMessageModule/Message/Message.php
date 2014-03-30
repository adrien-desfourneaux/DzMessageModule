<?php

/**
 * Fichier source pour le message de base.
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

use Zend\Stdlib\Message as ZendMessage;

/**
 * Classe de message de base.
 *
 * Etend Zend\Stdlib\Message pour permettre la possibilité de changer facilement de framework.
 *
 * @category Source
 * @package  DzMessageModule\Message
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class Message extends ZendMessage implements MessageInterface
{
    /**
     * {@inheritdoc}
     */
    public function createArgument($name)
    {
        $this->setMetadata($name, new Argument);
    }

    /**
     * {@inheritdoc}
     */
    public function mark($name)
    {
        $return = strtoupper(
            preg_replace(
                '/([a-z])([A-Z])/',
                '$1_$2',
                $name
            )
        );

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function unmark($mark)
    {
        $words = explode('_', strtolower($mark));
        $return = $words[0];
        for ($i=1; $i<count($words); $i++) {
            $return .= ucfirst($words[$i]);
        }

        return $return;
    }

    /**
     * Obtient le contenu du message.
     *
     * $this->content contient le contenu du message
     * avec des marqueurs pour chaque argument
     * ex: "marqueur"   => "MARQUEUR",
     *     "unMarqueur" => "UN_MARQUEUR"
     *
     * Cette méthode va transformer chaque marqueur
     * en chaine de caractère correspondant et retourner
     * le contenu transformé.
     *
     * @param boolean
     */
    public function getContent()
    {
        $content  = $this->content;
        $metadata = $this->getMetadata();

        // Filtrage des arguments parmi les metadata.
        // $arguments = array('name' => 'argument');
        // + Obtention des marqueurs pour chaque nom d'argument.
        // $marks = array('name' => 'marqueur');
        $arguments = array();
        $marks     = array();
        foreach ($metadata as $name => $value) {
            if ($value instanceof ArgumentInterface) {
                $arguments[$name] = $value;
                $marks[$name]     = $this->mark($name);
            }
        }

        // Circuit court ; aucun argument.
        if (count($arguments) == 0) {
            return $content;
        }

        // construction de la regex pour matcher les marqueurs
        // $markers: tableau des marqueurs (ex: "UN_MARQUEUR").
        $markers = array_values($marks);

        $marker  = preg_replace('/\_/', '\_', $markers[0]);
        $regex = '/(' . $marker . ')';

        for ($i=0; $i<count($markers); $i++) {
            $marker = preg_replace('/\_/', '\_', $markers[$i]);
            $regex .= '|(' . $marker . ')';
        }

        $regex .= '/';

        // Remplacement de gauche à droite des marqueurs du content
        // par "%s", et stockage de l'ordre des marqueurs.
        // $replaced: marqueurs qui ont été remplacés, dans l'ordre de
        // gauche à droite.
        $replaced = array();
        $count = 0;
        do {
            $content = preg_replace_callback(
                $regex,
                function ($matches) use (&$replaced) {
                    array_push($replaced, $matches[0]);

                    return '%s';
                },
                $content,
                1,
                $count
            );
        } while ($count != 0);

        // $args:     Arguments qui seront passés à sprintf.
        // $replaced: Tableau des marqueurs remplacés par %s dans l'ordre de gauche à droite.
        // $name:     Nom de l'argument associé au marqueur.
        // $argument: Argument correspondant au $name.
        $args = array();
        foreach ($replaced as $marker) {
            $name     = $this->unmark($marker);
            $argument = $this->__getArgument($name);
            array_push($args, $argument);
        }

        // Ajout du contenu en premier argument à sprintf.
        // PHP5 only:
        $args = array_merge((array) $content, $args);

        // Objet instances de Argument dans un contexte de
        // chaine de caractères (%s). Appel automatique
        // de Argument::__toString().
        $content = call_user_func_array('sprintf', $args);

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function __setArgument($name, $argument)
    {
        $num  = func_num_args();
        $args = func_get_args();

        $name     = $args[0];
        $argument = $args[1];

        if (!($argument instanceof ArgumentInterface)) {

            // On récupère un possible argument existant
            // depuis les metadata. Sinon on en cré un nouveau.
            $metadata = $this->getMetadata();
            if (array_key_exists($name, $metadata)) {
                $argument = $this->getMetadata($name);
            } else {
                $argument = new Argument;
            }

            // Contenu obligatoire.
            $content = $args[1];
            $argument->setContent($content);

            // Préfixe optionnel.
            if ($num >= 3) {
                $prefix = $args[2];
                $argument->setPrefix($prefix);
            }

            // Suffixe optionnel.
            if ($num >= 4) {
                $suffix = $args[3];
                $argument->setSuffix($suffix);
            }
        }

        $this->setMetadata($name, $argument);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __getArgument($name)
    {
        return $this->getMetadata($name);
    }

    /**
     * {@inherit}
     */
    public function __call($name, $arguments)
    {
        $metadata  = $this->getMetadata();
        $possibles = array_keys($metadata);
        $count     = count($possibles);

        for ($i=0; $i<$count; $i++) {
            $key = $possibles[$i];
            $setter = 'set' . ucfirst($key);
            $getter = 'get' . ucfirst($key);

            if ($name == $setter) {
                $method = '__setArgument';
                $args   = $arguments;
                array_unshift($args, $key);
                break;
            } elseif ($name == $getter) {
                $method = '__getArgument';
                $args   = array($key);
                break;
            }
        }

        if (isset($method) && isset($args)) {
            return call_user_func_array(array(&$this, $method), $args);
        }
    }
}
