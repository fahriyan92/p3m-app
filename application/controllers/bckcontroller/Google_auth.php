<?php

class Google_auth extends CI_Controller{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_auth','auth');
  }
  
  
  public function login()
  {
    $google = new Google_Client();
    $google->setClientId("768501364296-84u4rspafur4o259u6261s84nrq0mlnr.apps.googleusercontent.com");
    $google->setClientSecret("bEa2bulJyBQ8mHBkUCYmx1Pe");
    $google->setRedirectUri(site_url('google_auth/login'));
    $google->addScope('email');
    $google->addScope('profile');

    if(isset($_GET['code'])){
      $token = $google->fetchAccessTokenWithAuthCode($_GET['code']);

      if(!isset($token['error'])){
        $google->setAccessToken($token['access_token']);
        $this->session->userdata('access_token', $token['access_token']);


        $google_data = new Google_Service_Oauth2($google);

        $data = $google_data->userinfo->get();
        $waktu_now = date('Y-m-d H:i:s');

        echo json_encode($data);
        return ;

        // if($this->auth->terdaftarkah($data['id'] !== null)){
        //   $user_data = [
        //     'nama' => $data['given_name']. ' '.$data['family_name'],
        //     'email' => $data['email']
        //   ];

        //   $this->auth->update_user($data['id'], $user_data);
        // } else{ 
        //   $user_data = [
        //     'oath_uid' => $data['id'],
        //     'nama' => $data['given_name']. ' '.$data['family_name'],
        //     'email' => $data['email']
        //   ];

        //   $this->auth->insert_user($user_data);
        // }

      }
    }
  }

} 