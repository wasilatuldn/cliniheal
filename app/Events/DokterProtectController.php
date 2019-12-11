<?php
namespace App\Events;

use Phalcon\Mvc\Controller;

class DokterProtectController extends Controller
{
    public function beforeExecuteRoute()
    {
        if(!$this->session->has('dokter')){
            $this->flashSession->error('Anda bukan dokter, Anda tidak berhak akses');
            return $this->response->redirect('user/login');
        }
    }
    protected function back() {
        return $this->response->redirect($_SERVER['HTTP_REFERER']);
    }
}