<?php

namespace App\Resources\Panel;

use App\Core\View;
use App\Models\User;

class DashboardController
{
    public function index()
    {
        (new User)->verifyLogin();
        View::render('panel/dashboard/index.twig');
    }
}
