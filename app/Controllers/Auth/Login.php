<?php
/*
 *Ahutor:DIEGO CASALLAS
 *Busines: SINAPSIS TECHNOLOGIES
 *Date:13/08/2023
 *Description:General login management class
 */

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User\UserModel;
use DateTimeImmutable;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends BaseController
{
    public function show()
    {
        if (!session()->is_logged) {
            $data['title'] = 'Ingreso al sistema';
            $data['meta'] = view('assets/meta');
            $data['css'] = view('assets/css');
            $data['js'] = view('assets/js');
            return view('auth/login', $data);
        }
        return redirect()->route('dashboard');
    }

    public function signin()
    {
        if (
            !$this->validate([
                'User_email' => 'required|valid_email',
                'User_password' => 'required'
            ])
        ) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }
        $userEmail = trim($this->request->getVar('User_email'));
        $userPassword = trim($this->request->getVar('User_password'));

        $model = new UserModel();
        if (!$user = $model->getUserBy('User_email', $userEmail)) {
            return redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Usuario no registrado en el sistema']);
        } else {
            if ($user['Stat_id'] != 1) {
                return redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Usuario inactivo']);
            } else {
                if (!$model->verifyHash($userPassword, $user['User_password'])) {
                    /*  */
                    return redirect()->back()->with('msg', ['type' => 'danger', 'body' => 'Credenciales inválidas']);
                } else {
                    session()->set([
                        'UserId' => $user['User_id'],
                        'UserName' => $user['User_name'],
                        'CompId' => $user['Comp_id'],
                        'is_logged' => true
                    ]);
                    return redirect()->route('dashboard')->with('msg', ['type' => 'success', 'body' => 'Bienvenido a la Plataforma ' . $user['User_name']]);
                }
            }
        }
    }
    public function validateUserEmail()
    {
        if (!$this->validate(['User_email' => 'required|valid_email'])) {

            $data['message'] = 'danger';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = null;
            $data['csrf'] = csrf_hash();
        }
        $userEmail = trim($this->request->getVar('User_email'));
        $model = new UserModel();
        if (!$user = $model->getUserBy('User_email', $userEmail)) {
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = null;
            $data['csrf'] = csrf_hash();
        } else {
            $key = 'example_key';
            $date = new DateTimeImmutable();
            $expire_at = $date->modify('+6 minutes')->getTimestamp(); // Add 60 seconds
            $domainName = "https://www.sinapsist.com.co";
            $userId = $user['User_id'];
            $payload = [
                'iat' => $date->getTimestamp(),
                // Issued at: time when the token was generated
                'iss' => $domainName,
                // Issuer
                'nbf' => $date->getTimestamp(),
                // Not before
                'exp' => $expire_at,
                // Expire
                'User_id' => $userId,
                // User id
                'User_email' => $userEmail
                // User email
            ];

            $jwt = JWT::encode($payload, $key, 'HS256');
            $data['message'] = 'success';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = $jwt;
            $data['csrf'] = csrf_hash();
        }
        return json_encode($data);
    }
    public function signout()
    {
        session()->destroy();
        return redirect()->route('login');
    }

    public function changePassword()
    {

        try {
            $key = 'example_key';
            if (!session()->is_logged) {

                if (!empty($data['token'] = $this->request->getVar('changePassword'))) {
                    $data['title'] = 'Change Password';
                    $data['meta'] = view('assets/meta');
                    $data['css'] = view('assets/css');
                    $data['js'] = view('assets/js');

                    $data['result'] = JWT::decode($data['token'], new Key($key, 'HS256'));
                    return view('auth/changePassword', $data);
                }
            } else {

                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            $data['title'] = 'Change Password';
            $data['meta'] = view('assets/meta');
            $data['css'] = view('assets/css');
            $data['js'] = view('assets/js');
            $message = $e->getMessage();
            if ($message == "Expired token") {
                $data['message'] = $message;
            } else {
                $data['message'] = "Error with token";
            }
            return view('auth/changePasswordErro', $data);
        }
    }
    public function login()
    {
        $user = new UserModel();
        $Username = $this->request->getVar('Username');
        $Password = $this->request->getVar('UserPassword');
        $responsUser = $user->findUserByEmailPassword($Username, $Password);
        if ($responsUser == ResponseInterface::HTTP_NO_CONTENT) {
            $data['message'] = 'Error search user';
            $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
            $data['data'] = '';
        } else {

            $dataResult['token'] = getSignedJWTForUser($responsUser);
            $data['message'] = 'Search user';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] = $dataResult;
        }

        return json_encode($data);
    }
    public function sendNotification()
    {
        try {
            $linkToActive="";
            $attribute="changePassword";
           
            $key = 'example_key';
            $data['token'] =JWT::decode($this->request->getVar('token'), new Key($key, 'HS256'));
            $linkToActive=base_url().'login/passwChange?changePassword='.$this->request->getVar('token');
            $data['message'] = 'Send Email';
            $data['response'] = ResponseInterface::HTTP_OK;
            $data['data'] =$linkToActive;

            $to=$data['token']->User_email;
            $subject="";
            $message="";
            $template="";
           
        } catch (Exception $e) {
        }
        return json_encode($data);
    }
}
