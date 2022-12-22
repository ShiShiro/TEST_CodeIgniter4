<?php

namespace App\Controllers;
use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
    $data = [];

    helper(['form']);



    if($this -> request->getMethod() =='post') //   getMethod is not used anymore?
    {
            $rules = [

                'email' => 'required|min_length[6]max_length[50]|valid_email',
                'password' => 'required|min_length[8]max_length[255]|validateUser[email,password]',
               
            ];

            $errors = [
              'password' => [
                'validateUser' => 'Email or Password do not match'
              ]

            ];

            if(!$this -> validate($rules,$errors)){
                $data['validation'] = $this->validator;
            }
            else{
                $model = new UserModel();

                $user = $model->where('email', $this->request->getVar('email'))
                        ->first();

                $this->setUserSession($user);


                // $session -> setFlashdata('success' , 'Successful Registration');
                 return redirect() ->to('dashboard');

            }
    }

    echo view('templates/header', $data);
    echo view('login');
    echo view('templates/footer');
 }

 private function setUserSession($user){
        $data = [
            'id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
 }

 /*Test function (will be deleted later)*/
 
 public function test(){
    $db = \Config\Database::connect();


        /* If an established connection is available, then there's
        * no need to connect and select the database.
        *
        * Depending on the database driver, conn_id can be either
        * boolean TRUE, a resource or an object.
        */
        if ($db->initialize()){
            // we have a connection
            echo '1';
        } else {
            // NO Connections
            echo '0';
        }

        // or try
        if ($db->connID) {
            echo 'Success';
        }

        echo $db->query("INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `created_at`, `updated_at`) VALUES (NULL, 'test', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');");
 }
 public function register(){
    $data = [];

    helper(['form']);


    if($this->request->getMethod() === 'post') //   getMethod is not used anymore?
    {

            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
            ];

            if(!$this->validate($rules)){
                $data['validation'] = $this->validator;
            } else {
                $model = new UserModel();

                

                $newData = [
                    'firstname' => $this->request->getVar(),
                    'lastname' => $this->request->getVar(),
                    'email' => $this->request->getVar(),
                    'password' => $this->request->getVar(),
                ];
                $model->save($newData);

                $session = session();
                $session -> setFlashdata('success' , 'Successful Registration');
                return redirect() ->to('/');

            }
    }
    echo view('templates/header', $data);
    echo view('register');
    echo view('templates/footer');
  
 }

 public function profile(){
    $data = [];

    helper(['form']);

    if($this -> request->getMethod() =='post') //   getMethod is not used anymore?
    {
            $rules = [
                'firstname' => 'required|min_length[3]max_length[20]',
                'lastname' => 'required|min_length[3]max_length[20]',
        
            ];


            if($this->request->getPost('password' != '')){
                $rules['password'] = 'required|min_length[8]max_length[255]';
                $rules['password_confirm'] = 'matches[password]';
            }

            if(!$this -> validate($rules)){
                $data['validation'] = $this->validator;
            }
            else{
                $model = new UserModel();

                

                // $newData[
                //     'firstname' => $this ->request->getVar(),
                //     'lastname' => $this ->request->getVar(),
                //     'email' -> $this ->request->getVar(),
                //     'password' => $this ->request->getVar(),
                // ];
                // $model->save($newData);

                $session = session();
                $session -> setFlashdata('success' , 'Successful Registration');
                return redirect() ->to('/');

            }
    }

    echo view('templates/header', $data);
    echo view('profile');
    echo view('templates/footer');
  

 }



 
}

