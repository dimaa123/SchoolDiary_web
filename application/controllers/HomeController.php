<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {
	
	public function insertChatMsg() {
        $json = file_get_contents('php://input');
        $chatObject = (object) json_decode($json);
        $this->HomeModel->insertChatMsg($chatObject);
	}

	public function fetchChats() {
		$json = file_get_contents('php://input');
        $fetchObject = (object) json_decode($json);
        $this->HomeModel->fetchChats($fetchObject);
	}

	public function getContacts() {
		$json = file_get_contents('php://input');
                $statusObject = (object) json_decode($json);
                if($statusObject->status == "T") {
                	$this->HomeModel->getContacts("parents");
                } else {
                	$this->HomeModel->getContacts("teachers");
                }
	}

	public function addRecentChat() {
                $json = file_get_contents('php://input');
                $recentChatObject = (object) json_decode($json);
                $this->HomeModel->addRecentChat($recentChatObject);
	}

        public function getRecentChats() {
                $json = file_get_contents('php://input');
                $recentChatObject = (object) json_decode($json);   
                $this->HomeModel->getRecentChats($recentChatObject);
        }

        public function addGroup() {
                $json = file_get_contents('php://input');
                $groupObject = (object) json_decode($json);   
                $this->HomeModel->addGroup($groupObject); 
        }

        public function getGroups() {
                $json = file_get_contents('php://input');
                $emailObject = (object) json_decode($json);   
                $this->HomeModel->getGroups($emailObject);  
        }

}