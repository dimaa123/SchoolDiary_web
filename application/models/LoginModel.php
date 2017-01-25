<?php

class LoginModel extends CI_Model {
    
    public function login($loginObject, $table) {
        $count = $this->isEmailExist($loginObject->email, $table);
        if($count == 1) {
            $condition = array('email' => $loginObject->email, 'password' => $loginObject->password );
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($condition);
            $this->db->limit(1);
            $query = $this->db->get();
            $row = $query->row();
            $this->output
                        ->set_status_header(200)
                        ->set_content_type('application/json', 'utf-8')
                        ->set_output(json_encode($row))
                        ->_display();
                exit();
        } else {
            $this->output
                        ->set_status_header(401)
                        ->set_content_type('application/json', 'utf-8')
                        ->set_output(" { " . '"status"' . " : " . '"user does not exist"' . " } ")
                        ->_display();
                exit();
        }
    }	

    public function isEmailExist($email, $table) {
        $condition = array('email' => $email);
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->num_rows();
    }

}