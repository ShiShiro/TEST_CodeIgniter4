<?php

namespace App\Controllers;
use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
    $data = [];

    helper(['form']);

    echo view('templates/header', $data);
    echo view('login', $data);
    echo view('templates/footer', $data);
 }
 public function register(){
    $data = [];

    helper(['form']);

    if($this -> request->getMethod() =='post') //   getMethod is not used anymore?
    {
            $rules = [
                'firstname' => 'required|min_length[3]max_length[20]',
                'lastname' => 'required|min_length[3]max_length[20]',
                'email' => 'required|min_length[6]max_length[50]|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]max_length[255]',
                'password_confirm' => 'matches[password]',
            ];

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
    echo view('register');
    echo view('templates/footer', $data);
  
 }
 
}

