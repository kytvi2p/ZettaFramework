<?php

/**
 * Bootstrap для модуля Modules_Access
 *
 * @author Александр Хрищанович
 *
 */
class Modules_Access_Bootstrap extends Zetta_BootstrapModules {

	public function bootstrap() {

		parent::bootstrap();

		if (!System_Functions::tableExist('access_users')) {

			$_migrationManager = new Modules_Dbmigrations_Framework_Manager();
			$_migrationManager->upTo('Modules_Access_Migrations_CreateResourceTable');
			$_migrationManager->upTo('Modules_Access_Migrations_CreateRolesTable');
			$_migrationManager->upTo('Modules_Access_Migrations_CreateRulesTable');
			$_migrationManager->upTo('Modules_Access_Migrations_CreateUsersTable');
			$_migrationManager->upTo('Modules_Access_Migrations_SetDefaultResource');

		}

		/* Авторизуем пользователя, теперь везде можем использоваеть Zend_Auth::getInstance() */
		Modules_Access_Framework_Auth::getInstance()->bootstrap();

		/* Расставляем права доступа */
		Modules_Access_Framework_Acl::getInstance()->bootstrap();


	}

}