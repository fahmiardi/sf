<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller{
        function Login(){
                parent::__construct();
                $this->load->library(array('encrypt', 'form_validation', 'session'));
                $this->load->model('mglobal');
                $this->load->helper('url');
                $this->load->helper('captcha');
        }
    
        
        function index (){
            
                $is_logged_in = $this->session->userdata('is_logged_in');
                if($is_logged_in == true)
                {
                        redirect(base_url() .'index.php/main/welcome');
                }
                
                ####### proses login di sini
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required|callback_password_check');
                $this->form_validation->set_rules('ractha', 'Security Code', 'required|callback_captcha_check');
                        
                $this->form_validation->set_error_delimiters('<li>','</li>');
                $this->form_validation->set_message('required', 'Kolom <b>%s</b> harus diisi.');
                
                $hasil = "";
                #if($this->input->post('x')){
                        
                        if ($this->form_validation->run() != FALSE) {
                                
                                $username = $this->input->post('username');
                                $userdata = array (
                                    'username'          => $username,
                                    'group'             => $this->mglobal->showdata("user_group_id", "t_mtr_user", array("user_id"=>$username),"dblokal"),
                                    'jabatan'           => 'admin',
                                    'is_logged_in'      => true
                                );
                                $this->session->set_userdata($userdata);
                                redirect(base_url() . "index.php/main/welcome");
                        }
                #}
                $this->load->view("login-page");
        }
    
        function logout($id = 1){
            
            //$this->session->unset_userdata();
            $this->session->sess_destroy();
            redirect(base_url()."index.php/login");
        }
    
        function captcha_check($str)
        {
                if ($this->session->userdata('ratcha') <> $str)
                {
                        $this->form_validation->set_message('captcha_check', '<b>Kode Validasi</b> Salah');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
        
        function password_check($str)
        {
                if ($this->mglobal->showdata("user_id", "t_mtr_user", array("user_id"=>$this->input->post('username'),"user_password"=>md5($this->input->post('password'))),"dblokal") == "")                 
                {
                        $this->form_validation->set_message('password_check', '<b>Username dan/atau Password Anda Salah</b>');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
        
        function capcay(){
                $this->load->view("ratcha/ratcha_image");
        }
}