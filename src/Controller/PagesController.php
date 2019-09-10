<?php
declare(strict_types=1);

namespace App\Controller;


class PagesController extends AppController {

    public function index() {
        $this->viewBuilder()->setLayout('frame');
    }
}
