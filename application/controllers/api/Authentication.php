<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Authentication extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('user');
    }

    public function login_post() {
        // Get the post data
        $phone = $this->post('phone');
        $otp = $this->post('otp');
        $session_details = $this->post('session_details');
        
        // Validate the post data
        if(!empty($phone)){
            
            // Check if any user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'phone' => $phone,
                'status' => 1
            );
            $user = $this->user->getRows($con);
            // print_r($user);exit;
            
            if($user){
                if(!empty($otp)){

                    if($user['one_time_password'] == $otp){
                        $updateData = array('one_time_password'=>'');
                        $update = $this->user->update($updateData, $user['id']);
                        $verify_otp = json_decode($this->verify_otp($session_details, $otp), true);
                        // print_r($verify_otp);exit;
                        $user = $this->user->getRows($con);

                        if($verify_otp['Status'] == 'Success')
                        {
                            if($user['role'] == 2){
                                $user['user_logged'] = TRUE;
                            }
                            else 
                            {
                                $user['master_logged'] = TRUE;
                            }
                            // Set session data
                            $this->session->set_userdata($user);
                            // Set the response and exit
                            $this->response([
                                'status' => TRUE,
                                'message' => 'User login successful.',
                                'data' => $user
                            ], REST_Controller::HTTP_OK);
                        }
                        else
                        {
                            $this->response($verify_otp['Details'], REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }
                }

                // $otp = rand(1111,9999);
                $otp = 1234;
                $send_otp = json_decode($this->send_otp($phone, $otp), true);
                
                if($send_otp['Status'] == 'Success'){
                    $updateData = array('one_time_password'=>$otp);
                    $update = $this->user->update($updateData, $user['id']);

                    $this->response([
                        'status' => TRUE,
                        'message' => 'Otp send to your mobile number.',
                        'data' => $send_otp['Details']
                    ], REST_Controller::HTTP_OK);

                }
                else
                {
                    $this->response($send_otp['Details'], REST_Controller::HTTP_BAD_REQUEST);
                }
            }else{
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code
                $this->response("Wrong phone.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            // Set the response and exit
            $this->response("Provide phone.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function registration_post() {
        // Get the post data
        $first_name = strip_tags($this->post('first_name'));
        $last_name = strip_tags($this->post('last_name'));
        $email = strip_tags($this->post('email'));
        $phone = strip_tags($this->post('phone'));
        
        // Validate the post data
        if(!empty($first_name) && !empty($last_name) && !empty($email) && !empty($phone)){
            
            // Check if the given email already exists
            $con['returnType'] = 'count';
            $con['conditions'] = array(
                'phone' =>  $phone
            );
            $userCount = $this->user->getRows($con);
            
            if($userCount > 0){
                // Set the response and exit
                $this->response("The given phone already exists.", REST_Controller::HTTP_BAD_REQUEST);
            }else{
                // Insert user data
                $userData = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'phone' => $phone,
                    'role' => '2'
                );
                $insert = $this->user->insert($userData);
                
                // Check if the user data is inserted
                if($insert){
                    // Set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'The user has been added successfully.',
                        'data' => $insert
                    ], REST_Controller::HTTP_OK);
                }else{
                    // Set the response and exit
                    $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }else{
            // Set the response and exit
            $this->response("Provide complete user info to add.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function user_get($id = 0) {
        // Returns all the users data if the id not specified,
        // Otherwise, a single user will be returned.
        $con = $id?array('id' => $id):array('role' => 2);
        $users = $this->user->getRows($con);
        
        // Check if the user data exists
        if(!empty($users)){
            // Set the response and exit
            //OK (200) being the HTTP response code
            $this->response($users, REST_Controller::HTTP_OK);
        }else{
            // Set the response and exit
            //NOT_FOUND (404) being the HTTP response code
            $this->response([
                'status' => FALSE,
                'message' => 'No user was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function upload_post(){
        $id = strip_tags($this->post('id'));
        $name = strip_tags($this->post('name'));
        // Check if the given email already exists
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'id' => $id,
            'status' => 1
        );
        $user = $this->user->getRows($con);

        if($user){
            $file_name = $_FILES['document']['name'];
            $temp = explode(".", $file_name);
            $new_file_name = 'document_'. time() . '_' .rand(11111,99999). '.' . end($temp);

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "20480000",
                'max_height' => "10000",
                'max_width' => "10000"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('document')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                
                // Insert document data
                $documentData = array(
                    'users_id' => $id,
                    'name' => $name,
                    'document' => $img_url,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                );
                $insert = $this->user->insert($documentData, 'document');
                
                $cond['returnType'] = 'single';
                $cond['conditions'] = array(
                    'id' => $insert,
                );
                $document_info = $this->user->getRows($cond, 'document');

                if($insert)
                {
                    $this->response($document_info, REST_Controller::HTTP_OK);
                }
                else
                {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No document uploaded.'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No document uploaded.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }

        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No user was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function send_otp($phone, $otp)
    {
        return json_encode(array('Status'=>'Success', 'Details'=>'mydemosession'));
        
        $curl = curl_init();
        

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://2factor.in/API/V1/".SMS_API_KEY."/SMS/{$phone}/{$otp}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return json_encode(array('Status'=>'failed', 'Details'=>$err));
        } else {
            return $response;
        }
    }

    public function verify_otp($session_details, $otp){
        return json_encode(array('Status'=>'Success', 'Details'=>'OTP Matched.'));

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://2factor.in/API/V1/".SMS_API_KEY."/SMS/VERIFY/{$session_details}/{$otp}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return json_encode(array('Status'=>'failed', 'Details'=>$err));
        } else {
            return $response;
        }
    }
}