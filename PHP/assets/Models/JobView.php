<?php

namespace App\Controllers;

class JobView {

    public function render($response)
    {
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}