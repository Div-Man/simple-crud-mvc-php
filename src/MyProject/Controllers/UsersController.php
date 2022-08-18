<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\User as User;
use MyProject\Exceptions\InvalidArgumentException as InvalidArgumentException;
use MyProject\Models\Users\UserActivationService as UserActivationService;
use MyProject\Services\EmailSender as EmailSender;
use MyProject\Models\Users\UsersAuthService as UsersAuthService;

class UsersController extends MainController
{
	public function signUp()
	{
		if (!empty($_POST)) {
			try{
				$user = User::signUp($_POST);
			} catch(InvalidArgumentException $e){
				$this->view->render('/users/signUp.php', ['error' => $e->getMessage()]);
				return;
			}

			if ($user instanceof User) {

				
				$code = UserActivationService::createActivationCode($user);
				
				EmailSender::send($user, 'Активация', 'userActivation.php', [
					'userId' => $user->getId(),
					'code' => $code
				]);
				$this->view->render('/users/signUpSuccessful.php');
				return;
			}
		}
		
		 $this->view->render('/users/signUp.php');
	}

	public function activate(int $userId, string $activationCode)
	{
		$user = User::getById($userId);

		$isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
		if ($isCodeValid) {
			$user->activate($user->id);
			UserActivationService::deleteActivationCode($user);
			echo 'Ваша учётная запись активирована.';
		}
	}

	public function login()
	{
		if (!empty($_POST)) {
			try {
				$user = User::login($_POST);
				UsersAuthService::createToken($user);
				header('Location: /');
				exit();
			} catch (InvalidArgumentException $e) {
				$this->view->render('/users/login.php', ['error' => $e->getMessage()]);
				return;
			}
		}
		
		$this->view->render('/users/login.php');

	}

	public function logout()
	{
		UsersAuthService::deleteToken();
		$this->view->render('/');
	}
}