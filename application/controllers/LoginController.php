<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

	public function login() {
		$json = file_get_contents('php://input');
		$loginObject = (object) json_decode($json);
		if($loginObject->type == "T") {
			$this->LoginModel->login($loginObject, "teachers");
		} else {
			$this->LoginModel->login($loginObject, "parents");
		}
	}
}