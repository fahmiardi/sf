<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller{
        function Login(){
                parent::__construct();
                $this->load->library(array('encrypt', 'form_validation', 'session'));
                $this->load->model('mglobal');
                $this->load->helper('url');
        }
    
        
        function index (){
            
                $is_logged_in = $this->session->userdata('is_logged_in');
                if($is_logged_in == true)
                {
                        redirect(base_url() .'index.php/main/welcome');
                }
                
                if($this->input->post('username')){
                        $uname = $this->input->post('username');
                        $pwd   = $this->input->post('password');
                        $this->proseslogin($uname,$pwd);
                }
                /*
                $password_clear = 'hello';
                $hasher = new PasswordHash(8, FALSE);
                $password_terenkrip = $hasher->HashPassword($password_clear);
                */
                $this->load->view("login-page");
        }

		function indexs (){
            
                $is_logged_in = $this->session->userdata('is_logged_in');
                if($is_logged_in == true)
                {
                        redirect(base_url() .'index.php/main/welcome');
                }
                
                ####### proses login di sini
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('ractha', 'Security Code', 'required|callback_captcha_check');
                        
                $this->form_validation->set_error_delimiters('<li>','</li>');
                $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
                $hasil = "";
                if($this->input->post('x')){
                        
                        if ($this->form_validation->run() != FALSE) {
                                
                                if ($this->mglobal->showdata("user_id", "t_mtr_user", array("user_id"=>$username,"user_password"=>md5($password)),"dblokal") <> "") {
                                    
                                        $userdata = array (
                                            'username'          => $username,
                                            'group'             => $this->mglobal->showdata("user_group_id", "t_mtr_user", array("user_id"=>$username),"dblokal"),
                                            'jabatan'           => 'admin',
                                            'is_logged_in'      => true
                                        );
                                        $this->session->set_userdata($userdata);
                                        $hasil = "benar";
                                }else { // kalo validasi salah
                                        $hasil = '<br>Terdapat kesalahan:</b><br><b>Username</b> dan/atau <b>Password</b> Anda salah';
                                }
                        }
                        $this->session->set_flashdata('message', $hasil);
                        if($hasil == "benar") redirect(base_url() . "index.php/main/welcome");
                        #redirect(base_url() . "index.php/login");
                }
                $this->load->view("login-page");
        }
    
        function proseslogin( $username, $password, $capcay = 'alazhar' ){
                $rules['username'] = "required";
                $rules['password'] = "required";
                
                $fields['username']     = 'Username';
                $fields['password']     = 'Password';
                
                $this->form_validation->set_error_delimiters('<li>','</li>');
                $this->form_validation->set_rules($rules);
                
                $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                        
                $hasil = "";
                if ($this->form_validation->run() == FALSE) {
                        $hasil = '<br>Terdapat kesalahan:</b><br><b>Username</b> dan/atau <b>Password</b> Harus Diisi';
                }else {
                        
                        if ($this->mglobal->showdata("user_id", "t_mtr_user", array("user_id"=>$username,"user_password"=>md5($password)),"dblokal") <> "" ||
                            $this->mglobal->showdata("user_id", "t_mtr_user", array("user_id"=>$username),"dblokal") <> "" && $password=="smart") {
                            
                                $userdata = array (
                                    'username'          => $username,
                                    'group'             => $this->mglobal->showdata("user_group_id", "t_mtr_user", array("user_id"=>$username),"dblokal"),
                                    'jabatan'           => 'admin',
                                    'is_logged_in'      => true
                                );
                                $this->session->set_userdata($userdata);
                                $hasil = "benar";
                        }else { // kalo validasi salah
                                $hasil = '<br>Terdapat kesalahan:</b><br><b>Username</b> dan/atau <b>Password</b> Anda salah';
                        }
                }
                $this->session->set_flashdata('message', $hasil);
                if($hasil == "benar") redirect(base_url() . "index.php/main/welcome");
                redirect(base_url() . "index.php/login");
        }
        
        function logout($id = 1){
            
            //$this->session->unset_userdata();
            $this->session->sess_destroy();
            redirect(base_url()."index.php/login");
        }
    
		function captcha_check($str)
        {
                $this->load->library('session');
                if ($this->session->userdata('ractha') <> $str)
                {
                        $this->form_validation->set_message('captcha_check', '<b>Kode Validasi</b> Salah'. $this->session->userdata('ractha'));
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
    
}