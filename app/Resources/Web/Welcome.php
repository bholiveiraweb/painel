<?php

namespace App\Resources\Web;

use App\Core\View;
use App\Models\Department;
use App\Models\Product;

class Welcome
{
    public function index()
    {
    	$data['departments'] = (new Department)->getAllDepartments();
        $data['products'] = (new Product)->getAllProducts();

        View::render('web/index.twig', $data);
    }

    public function department($slug)
    {
    	$data['departments'] = (new Department)->getAllDepartments();
    	$data['products'] = (new Product)->getProductsByDepartment($slug);

    	View::render('web/index.twig', $data);
    }
}
