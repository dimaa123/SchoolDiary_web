<?php

/**
* 
*/
class HomeModel extends CI_Model {
	
	public function insertChatMsg($chatObject) {
		$data = array(
            'created_at' => time(),
            'sender' => $chatObject->sender,
            'receiver' => $chatObject->receiver,
            'sender_flag' => 1,
            'receiver_flag' => 1,
            'msg' => $chatObject->msg
        );
		$this->db->insert('chat', $data);
        $chatArray = (object)array('sender' => 'a', 'receiver' => 'b' );
        $this->fetchChatsAfterInsertChat($chatArray);
	}

    public function fetchChats($fetchObject) {
        $condition = array('sender' => $fetchObject->sender, 'receiver' => $fetchObject->receiver);
        $this->db->select('*');
        $this->db->from('chat');
        $this->db->where($condition);
        $query = $this->db->get();
        $chats = $query->result();
        echo json_encode($chats);
    } 

    public function fetchChatsAfterInsertChat($fetchObject) {
        $condition = array('sender' => $fetchObject->sender, 'receiver' => $fetchObject->receiver);
        $this->db->select('*');
        $this->db->from('chat');
        $this->db->where($condition);
        $this->db->order_by("id","desc");
        $this->db->limit(10);
        $query = $this->db->get();
        $chats = $query->result();
        echo json_encode($chats);

    }
    /****************************************************************/
    public function getContacts($table) {
        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        $contacts = $query->result();
        echo json_encode($contacts);
    }

    public function addRecentChat($recentChatObject) {
        $condition = array('teacher' => $recentChatObject->teacher, 'parents' => $recentChatObject->parents);
        $this->db->select('*');
        $this->db->from('recentChats');
        $this->db->where($condition);
        $query = $this->db->get();
        $count = $query->num_rows();
        if($count == 0) {
            $data = array('teacher' => $recentChatObject->teacher, 'parents' => $recentChatObject->parents);
            $this->db->insert('recentChats', $data);
        } else {
            $data = array('teacher' => $recentChatObject->teacher, 'parents' => $recentChatObject->parents);
            $this->db->where($condition);
            $this->db->update('recentChats', $data);
        }
    }

    public function getRecentChats($recentChatObject) {
        if($recentChatObject->which == "T") {
            $condition = array("teacher" => $recentChatObject->teacher);
            $this->db->select('parents');
            $this->db->from('recentChats');
            $this->db->where($condition);
            $query = $this->db->get();
            $result = $query->result();
            $data = [];
            foreach ($result as $value) 
                $data[] = $value->parents;

            $this->db->select('*');
            $this->db->from('parents');
            $this->db->or_where_in('email', $data);
            $finalQuery = $this->db->get();
            echo json_encode($finalQuery->result());

        } else {
            $condition = array("parents" => $recentChatObject->teacher);
            $this->db->select('teacher');
            $this->db->from('recentChats');
            $this->db->where($condition);
            $query = $this->db->get();
            $result = $query->result();
            $data = [];
            foreach ($result as $value) 
                $data[] = $value->teacher;

            $this->db->select('*');
            $this->db->from('teachers');
            $this->db->or_where_in('email', $data);
            $finalQuery = $this->db->get();
            echo json_encode($finalQuery->result());
        }

    }

    public function addGroup($groupObject) {
        $groupID = time();
        $data = array("groupName" => $groupObject->groupName, "groupID" => $groupID, "groupOwner" => $groupObject->groupOwner );
        $this->db->insert('parentsGroup', $data);


        // insert multiple rows
        $groupMemberArray = [];
        foreach ($groupObject->groupMembers as $member) {
            $groupMemberArray[] = array('groupID' => $groupID, 'email' => $member);
        }
        $this->db->insert_batch('groupMembers', $groupMemberArray);
    }

    public function getGroups($groupObject) {
        $condition = array('groupOwner' => $groupObject->status);
        $this->db->select('groupID, groupName');
        $this->db->from('parentsGroup');
        $this->db->where($condition);
        $query = $this->db->get();
        $result = $query->result();
        $groupIDArray = [];
        foreach ($result as $value) 
            $groupIDArray[] = array('groupID' => $value->groupID, 'groupName' => $value->groupName);

        $groupMemberArray = [];
        foreach ($groupIDArray as $object) {
            $emailCondition = array('groupID' => $object['groupID']);
            $this->db->select('email');
            $this->db->from('groupMembers');
            $this->db->where($emailCondition);
            $emailQuery = $this->db->get();
            $groupMemberArray[] = array('groupID' => $object['groupID'],
             'groupName' => $object['groupName'], 'email' => $emailQuery->result());
        }


        $parentsArray = [];
        $users = [];
        foreach ($groupMemberArray as $row) {
            foreach ($row['email'] as $value) {
                $parentscondition = array('email' => $value->email);
                $this->db->select('*');
                $this->db->from('parents');
                $this->db->where($parentscondition);
                $parentsQuery = $this->db->get();
                //$users[] = $parentsQuery->result();
                foreach ($parentsQuery->result() as $obj) 
                    $users[] = array('email' => $obj->email, 'name' => $obj->name );

            }
            $parentsArray[] = array('groupID' => $row['groupID'], "groupName" => $row['groupName'], "users" => $users );
        }
        echo json_encode($parentsArray);
    }

    public function changeGroupName($groupObject) {
        $condition = array('groupID' => $groupObject->groupID);
        $data = array('groupName' => $groupObject->groupName);
        $this->db->select('*');
        $this->db->from('parentsGroup');
        $this->db->where($condition);
        $this->db->update('parentsGroup', $data);

        $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(" { " . '"status"' . " : " . '"user does not exist"' . " } ")
                    ->_display();
            exit();
    }

    public function removeMembers($groupObject) {
        $condition = array('groupID' => $groupObject->groupID);
        $data = [];
        foreach ($groupObject->users as $value) {
            $data[] = $value->email;
        }
        $this->db->where($condition);
        $this->db->where_in('email', $data);
        $this->db->delete('groupMembers');
    }

    public function addMembers($groupObject) {
        $groupMemberArray = [];
        foreach ($groupObject->users as $member) {
            $groupMemberArray[] = array('groupID' => $groupObject->groupID, 'email' => $member->email);
        }
        $this->db->insert_batch('groupMembers', $groupMemberArray);
    }

    public function sendNotification($notificationObject) {
        $apiAccessKey = "AAAAwIg6XDs:APA91bFDNSqvOUDgViAZG0n_3YKZu17tEdJETCZQxz4Q6xXnwR7vYRec7dp-E4_6sFhYVvrgjcRP8SAGLJTz5q6wUqUajlLCm5OYCFByRmhA7e5FXlAtRZAtwpGcQIv8MgB_FHNz30RP";
        
        $notification = array (
            'body' => "School Dairy",
            'title' => "You got a new message.",
            'icon' => 'myicon',
        );

        $fields = array (
            'to' => $notificationObject->status,
            'notification' => $notification,
            'priority' => 'high'
        );
        
        $headers = array (
            'Authorization: key=' . $apiAccessKey,
            'Content-Type: application/json'
        );
        
        /*$jsonDataEncoded = json_encode($fields);
        $this->curl->create('https://fcm.googleapis.com/fcm/send');
        $this->curl->option(CURLOPT_HTTPHEADER, $headers);
        $this->curl->post($jsonDataEncoded);
        $result = $this->curl->execute();
        print_r($result);*/


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;        
    }


    public function updateToken($userObject) {
        $condition = array("email" => $userObject->email);
        $data = array('token' => $userObject->token);
        if($userObject->which == "T") {
            $this->db->select('*');
            $this->db->from('teachers');
            $this->db->where($condition);
            $this->db->update('teachers', $data);
        } else {
            $this->db->select('*');
            $this->db->from('parents');
            $this->db->where($condition);
            $this->db->update('parents', $data);
        }  
    }


    public function uploadProfilePicture($profileObject) {
        $fileName = time().$_FILES[$profileObject->file]['name'];
        $config = array(
            'upload_path' => "/images/",
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