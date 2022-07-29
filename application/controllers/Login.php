<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('User_models');
    }

    public function view_login(){
        $this->load->view('view_login_page');
    }

    public function proses(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $data = $this->User_models->cek_login($username);
        if($data){
            if($data['password'] == $password){
                $data_user['user'] = [
                    "username" => $data['username'],
                    "level_name" => $data['level_name']
                ];
                if($data['id_user_level'] == '1'){
                    $this->session->set_userdata($data_user);
                    redirect('user_page');
                }else if ($data['id_user_level'] == '2'){
                    $this->session->set_userdata($data_user);
                    redirect('karyawan_page');
                }else{
                    echo 'Anda Belum Memiliki Hak akses';
                }
            }else{
                echo "Password Anda Salah";
            }
        }else{
            echo "Anda Belum Terdaftar";
        }

        // echo $username;
        // echo '<br>';
        // echo $password;
        // echo '<br>';
        // die();
    }

    public function logout(){
        $user = array('user');
        $this->session->unset_userdata($user);
        redirect('login_page');
    }

}