<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\MethodNotAllowedException;


class PagesController extends AppController {

    public function index() {
        $this->viewBuilder()->setLayout('frame');
    }

    public function paginator() {
        //Only ship html template
        return;
    }

    public function csrf() {
        if (!$this->isJsonRequest()) {
            throw new MethodNotAllowedException();
        }
        $this->set('success', true);
        $this->viewBuilder()->setOption('serialize', ['success']);
    }
}
