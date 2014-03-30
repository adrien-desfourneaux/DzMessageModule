DzMessageModule
=========

Module de gestion de messages d'informations et d'erreurs pour ZF2.

DzMessageModule est un module de gestion de messages pour ZF2. Il est écrit et maintenu par Adrien Desfourneaux (aka Dieze) &lt;dieze51@gmail.com&gt;. Le projet est hébergé par GitHub à l'adresse [https://github.com/dieze/DzMessageModule.git](https://github.com/dieze/DzMessageModule.git).

Fonctionnalités
-------------

Le module DzMessageModule permet de gérer les messages d'erreurs et d'informations d'un programme sous la forme de classes. Des classes génériques existent pour les erreurs que l'utilisateur pourrait rencontrer dans un logiciel.

### MessageManager

Le module DzMessageModule ajoute un nouveau service manager appelé *MessageManager* au service manager de Zend Framework 2. Le *MessageManager* permet d'obtenir un message à partir d'une clé (chaîne de caractères).

Par exemple, à l'intérieur d'un controller ZF2, on peut récupérer le message d'erreur générique depuis le *MessageManager* de cette façon :

	$locator       = $this->getServiceLocator();
	$messages      = $locator->get('MessageManager');
	$errorMessage  = $messages->get('error message');

Plusieurs messages sont déjà enregistrés auprès du *MessageManager*, tels que :

* Message : Message générique
* ErrorMessage : Message d'erreur générique
* ActionFailed : Une action a échouée
* DeleteFailed : La suppression a échouée
* FieldError : Erreur de champ d'entrée utilisateur
* FieldValueEmpty : La valeur du champ est vide
* FieldValueTooLong : La valeur du champ est trop longue
* ElementNotFound : L'élément recherché n'a pas été trouvé
* ElementsNotFound : Les éléments recherchés n'ont pas été trouvés.

etc...

La classe DeleteFailed héritant de ActionFailed héritant de ErrorMessage, etc...

### Message et argument de message

Les messages du DzMessageModule héritent des messages du Zend Framework 2 (Zend\Stdlib\Message). Ils contiennent un texte que l'on récupère via :

	$message->getContent();

Pour personnaliser le contenu, un message peut avoir des *arguments* de messsage. Un argument se compose d'un préfixe, un contenu et un suffixe. Le préfixe sera affiché avant le contenu et le suffixe après.

### Créer ses propres messages

Pour créer un message d'erreur d'achat de produit échoué par exemple, créer une classe MyModule\Message\Error\ProductPurchaseFailed qui hérite de DzMessageModule\Message\ErrorMessage.

	<?php
	
	namespace MyModule\Message\Error;
	
	use DzMessageModule\Message\Error\ErrorMessage;
	
	class ProductPurchaseFailed extends ErrorMessage
	{
		public function __construct()
		{
			$this->createArgument('product');
			
			$this->setProduct('chaussure de sport', ' de la ', ', malheureusement, ');
			
			$this->setContent("L'achat" . $this->mark('product') . "a échoué");
		}
	}
	
$this->createArgument('product') permet de créer un argument 'product'. On peut alors obtenir le produit avec $this->getProduct() et le définir avec $this->setProduct('contenu', 'préfix', 'suffixe'). $this->mark('argument') permet de mettre un marqueur qui indique la place de l'argument dans le contenu du message.

	$message = new ProductPurchaseFailed();
	return $message->getContent();

retournera : "L'achat de la chaussure de sport, malheureusement, a échoué".

	$message = new ProductPurchaseFailed();
	$message->setProduct('Télévision HD');
	return $message->getContent();
	
retournera : "L'achat de la Télévision HD, malheureusement, a échoué".

### Enregistrer ses messages auprès du MessageManager

Pour pouvoir récupérer ses messages auprès du *MessageManager* il faut les déclarer. Il y a deux façons de déclarer des nouveaux messages :

#### via l'interface MessageProviderInterface

Dans le fichier Module.php
	
	<?php
	
	namespace MyModule;
	
	use DzMessageModule\ModuleManager\Feature\MessageProviderInterface;
	
	class Module implements
		MessageProviderInterface
	{
		public function getMessageConfig()
		{
			return array(
				'invokables' => array(
					'MyModule\ProductPurchaseFailed' => 'MyModule\Message\Error\ProductPurchaseFailed',
				),
				'aliases' => array(
					'product purchase failed' => 'MyModule\ProductPurchaseFailed',
				),
			);
		}
	}
	
### via le module.config.php

Dans le fichier Module.php

	<?php
	
	namespace MyModule;
	
	use Zend\ModuleManager\Feature\ConfigProviderInterface;
	
	class Module implements
		ConfigProviderInterface
	{
		public function getConfig()
		{
			return include __DIR__ . '/config/module.config.php';
		}
	}
	
Dans le fichier config/module.config.php

	<?php
	
	return array(
		'messages' => array(
			invokables' => array(
				'MyModule\ProductPurchaseFailed' => 'MyModule\Message\Error\ProductPurchaseFailed',
			),
			'aliases' => array(
				'product purchase failed' => 'MyModule\ProductPurchaseFailed',
			),
		),
	);
			

### Plugins de controller

#### Message

Le plugin de controller *Message* permet d'obtenir un message à partir de sa clé dans le *MessageManager*. Si la clé n'existe pas dans le *MessageManager*, alors le plugin retourne un nouveau message qui a comme contenu la chaîne de caractères passée en paramètre du plugin.

Depuis un controller :
	
	$message = $this->message('action failed');
	return $message->getContent();

retournera : "L'action a échouée".

	$message = $this->message("Coucou me revoilà!");
	return $message->getContent();
	
retournera : "Coucou me revoilà!".

#### MessageModel

Le plugin de controller *MessageModel* permet d'obtenir un ViewModel à partir d'un message, obtenu via la clé du message, ou directement en donnant le contenu du message. Le template par défaut des messages est *dz-message-module/partial/message.phtml*.

Depuis un controller :
	
	return $this->messageModel('action failed');

retournera un ViewModel avec le contenu du message d'échec d'une action.

Le plugin *MessageModel* possède un deuxième argument permettant d'utiliser un autre template que celui par défaut.

#### MessageException

Le plugin de controller *MessageException* permet d'obtenir une exception *MessageException* qui contient un message, obtenu via la clé du message, ou directement en donnant le contenu du message. Le template par défaut des exceptions *MessageException* est *dz-message-module/error/message.phtml*.

Depuis un controller :
	
	throw $this->messageException('action failed');
	
enverra une exception *MessageException* contenant le message donné en paramètre. Pour afficher le message contenu dans l'exception :

	catch (\DzMessageModule\Exception\MessageException $ex) {
		echo $ex->getMessage();	
	}
	
Le plugin *MessageException* possède un deuxième argument permettant d'utiliser un autre template que celui par défaut.

Utiliser le MessageManager dans ses classes
-----------

Pour injecter le *MessageManager* dans ses propres classes, implémenter l'interface *DzMessageModule\Message\MessagePluginManagerAwareInterface*.

Le filtre d'entrées utilisateur *DzMessageModule\InputFilter\InputFilter* implémente cette interface. La classe InputFilter améliore l'InputFilter du Zend Framework 2 en lui permettant d'accéder au MessageManager via la méthode *message()* :

	$message = $this->message('error message');
	

Chaînage des méthodes
-------

La classe *Message* est implémenté de telle sorte que l'on peut chaîner les méthodes.

Dans un controller :
	
	return $this->message('action failed')->setAction('suppression', ' de')->getContent();
	
retournera : "L'action de suppression a échouée."

Scripts
-----------

###qa.sh

Le script DzBaseModule/bin/qa.sh est un script d'assurance qualité du code. Il permet de gérer la qualité du code et la documentation.

Vérifier la conformité du code avec les standards :

    bin/qa.sh code check

Modifier le code source pour qu'il soit conforme aux standards :

    bin/qa.sh code fix

Générer la documentation (la documentation se situera dans /doc)

    bin/qa.sh doc gen

Pour un aperçu complet des fonctionnalités de qa.sh :

    bin/qa.sh help


Licence
--------------

Copyright 2014 Adrien Desfourneaux

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.