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
}