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

        public function changeGroupName() {
                $json = file_get_contents('php://input');
                $groupObject = (object) json_decode($json);   
                $this->HomeModel->changeGroupName($groupObject);
        }

        public function removeMembers() {
                $json = file_get_contents('php://input');
                $groupObject = (object) json_decode($json);   
                $this->HomeModel->removeMembers($groupObject);  
        }

        public function addMembers() {
                $json = file_get_contents('php://input');
                $groupObject = (object) json_decode($json);   
                $this->HomeModel->addMembers($groupObject);
        }

        public function sendNotification() {
                $json = file_get_contents('php://input');
                $notificationObject = (object) json_decode($json);   
                $this->HomeModel->sendNotification($notificationObject);
        }

        public function updateToken() {
                $json = file_get_contents('php://input');
                $userObject = (object) json_decode($json);   
                $this->HomeModel->updateToken($userObject);
        }

        public function uploadProfilePicture() {
                $fileName = $_FILES['file']['name'];
                $config = array(
                    'upload_path' => "./images/",
                    'allowed_types' => "gif|jpg|png|jpeg",
                    'overwrite' => TRUE,
                    'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "768",
                    'max_width' => "1024",
                    'file_name' => $fileName
                    );
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('file')) {
                    echo "uploded";
                }else {
                    echo "error";
                }
        }

}