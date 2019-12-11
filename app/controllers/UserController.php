<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class UserController extends Controller
{
    
    public function createAction()
    {

    }


    public function storeAction()
    {

        if($this->request->getPost('tipe') == "dokter")
        {
            $dokter = new Dokter();
            $dokter->username = $this->request->getPost('username');
            $dokter->email = $this->request->getPost('email');
            $dokter->nama = $this->request->getPost('nama');
            $dokter->str = $this->request->getPost('str');
            $password = $this->request->getPost('password');
            $dokter->password = $this->security->hash($password);

            $dokter->save();
            $this->response->redirect();

        }
        elseif($this->request->getPost('tipe') == "apoteker")
        {
            $apoteker = new Apoteker();
            $apoteker->username = $this->request->getPost('username');
            $apoteker->email = $this->request->getPost('email');
            $apoteker->nama = $this->request->getPost('nama');
            $apoteker->str = $this->request->getPost('str');
            $password = $this->request->getPost('password');
            $apoteker->password = $this->security->hash($password);

            $apoteker->save();
            $this->response->redirect();

        }
        elseif($this->request->getPost('tipe') == "admin")
        {
            $admin = new Admin();
            $admin->username = $this->request->getPost('username');
            $admin->email = $this->request->getPost('email');
            $admin->nama = $this->request->getPost('nama');
            $password = $this->request->getPost('password');
            $admin->password = $this->security->hash($password);

            $admin->save();
            $this->response->redirect();

        }
        
    }

    public function loginAction()
    {

    }

    public function storeloginAction()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if($this->request->getPost('tipe') == "dokter")
        {
            $user = Dokter::findFirst("username='$username'");

            if ($user) {
                if ($this->security->checkHash($password, $user->password)) {
                    $this->session->set(
                        'auth',
                        [
                            'id' => $user->idDokter,
                            'username' => $user->username,
                            'tipe' => '1',
                        ]
                    );
                    (new Response())->redirect('dokter/home')->send();
                }
            }
            else{
                $this->response->redirect('user/login');
            }

        }
        elseif($this->request->getPost('tipe') == "apoteker")
        {
            $user = Apoteker::findFirst("username='$username'");

            if ($user) {
                if ($this->security->checkHash($password, $user->password)) {
                    $this->session->set(
                        'auth',
                        [
                            'id' => $user->idApoteker,
                            'username' => $user->username,
                            'tipe' => '2',
                        ]
                    );
                    (new Response())->redirect('apoteker/home')->send();
                }
            }
            else{
                $this->response->redirect('user/login');
            }

        }
        elseif($this->request->getPost('tipe') == "admin")
        {
            $user = Admin::findFirst("username='$username'");

            if ($user) {
                if ($this->security->checkHash($password, $user->password)) {
                    $this->session->set(
                        'auth',
                        [
                            'id' => $user->idAdmin,
                            'username' => $user->username,
                            'tipe' => '3',
                        ]
                    );
                    (new Response())->redirect('admin/home')->send();
                }
            }
            else{
                $this->response->redirect('user/login');
            }

        }

    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect();
    }

}