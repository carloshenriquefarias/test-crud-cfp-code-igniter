<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Users extends BaseController 
{

  private $userModel;

  public function __construct()
  {
    $this->userModel = new \App\Models\UserModel();
  }


  public function getAllUsers()
  {
    try {
        $users = $this->userModel->findAll();
        $response['status'] = true;
        $response['data'] = $users;
        $response['statusCode'] = 200;
        return $this->response->setStatusCode($response['statusCode'])->setJSON($response);

    } catch (\Throwable $th) {
        $response['status'] = false;
        $response['message'] = $th->getMessage();
        $response['statusCode'] = 500;

        return $this->response->setStatusCode($response['statusCode'])->setJSON($response);        
    }
  }

  public function createUser()
  {
      try {
          $postData = $this->request->getPost();        
          if (empty($postData)) {
              $response['status'] = false;
              $response['message'] = "No data provided";
              $response['statusCode'] = 400;
  
              return $this->response->setStatusCode($response['statusCode'])->setJSON($response);
          }

          $userSaved = $this->userModel->protect(false)->save($postData);
  
          if ($userSaved) {
              $response['status'] = true;
              $response['message'] = "User saved successfully!";
              $response['statusCode'] = 200;
              return $this->response->setStatusCode($response['statusCode'])->setJSON($response);
          } 
          else {
              $response['status'] = false;
              $response['message'] = $this->userModel->errors();
              $response['statusCode'] = 500;
              return $this->response->setStatusCode($response['statusCode'])->setJSON($response);
          }
      } catch (\Throwable $th) {
  
          $response['status'] = false;
          $response['message'] = $th->getMessage();
          $response['statusCode'] = 500;
  
          return $this->response->setStatusCode($response['statusCode'])->setJSON($response);
      }
  }
  
  public function updateUser() {
    try {
        $postData = $this->request->getPost();

        if (empty($postData['password'])) {
            unset($postData['password']);
        }

        if (!$this->userModel->validate($postData)) {
            $response['status'] = false;
            $response['message'] = $this->userModel->errors();
            return $this->response->setJSON($response);
        }

        $saved = $this->userModel->protect(false)->save($postData);

        if ($saved) {
            $response['status'] = true;
            $response['message'] = "Saved successfully!";
            $response['statusCode'] = 200;
            return $this->response->setStatusCode($response['statusCode'])->setJSON($response);
        } else {
            $response['status'] = false;
            $response['message'] = "Failed to save user!";
            $response['statusCode'] = 500;
            return $this->response->setStatusCode($response['statusCode'])->setJSON($response);
        }
    } catch (\Throwable $th) {
        $response['status'] = false;
        $response['message'] = $th->getMessage();
        $response['statusCode'] = 500;
        return $this->response->setStatusCode($response['statusCode'])->setJSON($response);

    }
  }


    public function deleteUser() {
      try {
          $postData = $this->request->getPost();

          if (empty($postData) || !isset($postData['id'])) {
            $response['status'] = false;
            $response['message'] = "ID is required!";
            $response['statusCode'] = 400;

            return $this->response->setStatusCode($response['statusCode'])->setJSON($response);
          } 
          
          $id = $postData['id'];

          if ($this->userModel->delete($id)) {
            $response['status'] = true;
            $response['message'] = "Deleted successfully!";
            $response['statusCode'] = 200;
            return $this->response->setStatusCode($response['statusCode'])->setJSON($response);

          } else {
            $response['status'] = false;
            $response['message'] = "Failed to delete user!";
            $response['statusCode'] = 500;
            return $this->response->setStatusCode($response['statusCode'])->setJSON($response);
          }

          
      } catch (\Throwable $th) {
        $response['status'] = false;
        $response['message'] = $th->getMessage();
        $response['statusCode'] = 500;
        return $this->response->setStatusCode($response['statusCode'])->setJSON($response);
      }

    }

    
   
  

}

