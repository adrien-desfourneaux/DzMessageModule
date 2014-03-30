<?php

/**
 * Fichier de module de DzMessageModule.
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
 * @package  DzMessageModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */

namespace DzMessageModule;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\Feature\InputFilterProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * Classe module de DzMessageModule.
 *
 * @category Source
 * @package  DzMessageModule
 * @author   Adrien Desfourneaux (aka Dieze) <dieze51@gmail.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 * @link     https://github.com/dieze/DzMessageModule
 */
class Module implements
	InitProviderInterface,
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
	ConfigProviderInterface,
    ControllerPluginProviderInterface,
    InputFilterProviderInterface,
    ServiceProviderInterface
{
	/**
     * Initialise le ModuleManager.
     *
     * @param  ModuleManagerInterface $manager Gestionnaire de module.
     *
     * @return void
     */
    public function init(ModuleManagerInterface $manager)
    {
        $eventManager = $manager->getEventManager();

        // Ajoute le nouveau ServiceManager MessageManager au ServiceListener.
        $eventManager->attach(new Listener\AddMessageManagerListener(), 100);
    }

    /**
     * Ecoute l'événement bootstrap.
     *
     * @param EventInterface $event Evénement Mvc.
     *
     * @return void
     */
    public function onBootstrap(EventInterface $event)
    {
        $application  = $event->getTarget();
        $eventManager = $application->getEventManager();

        // Gestion de l'exception \DzMessageModule\Exception\MessageException
        // lors du rendu.
        $eventManager->attach(new Listener\MessageExceptionListener(), 100);
    }

    /**
     * Retourne un tableau à parser par Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../../autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * Retourne la configuration à fusionner avec
     * la configuration de l'application
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerPluginConfig()
    {
        return array(
            'invokables' => array(
                'DzMessageModule\MessageModel' => 'DzMessageModule\Controller\Plugin\MessageModel',
            ),
            'factories' => array(
                'DzMessageModule\Message'          => 'DzMessageModule\Controller\Plugin\Factory\MessageFactory',
                'DzMessageModule\MessageException' => 'DzMessageModule\Controller\Plugin\Factory\MessageExceptionFactory',
            ),
            'aliases' => array(
                'message'          => 'DzMessageModule\Message',
                'messageException' => 'DzMessageModule\MessageException',
                'messageModel'     => 'DzMessageModule\MessageModel',
            ),
        );
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getInputFilterConfig()
    {
        return array(
            'factories' => array(
                'DzMessageModule\InputFilter' => 'DzMessageModule\InputFilter\Factory\InputFilterFactory',
            ),
        );
    }

    /**
     * Doit retourner un objet de type \Zend\ServiceManager\Config
     * ou un tableau pour créer un tel objet.
     *
     * @return array|\Zend\ServiceManager\Config
     *
     * @see ServiceProviderInterface
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'DzMessageModule\MessageManager' => 'DzMessageModule\Factory\MessageManagerFactory',
            ),
            'aliases' => array(
                'MessageManager' => 'DzMessageModule\MessageManager',
            ),
        );
    }
}
