<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AppFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        if (!session()->is_logged) {
            return redirect()->route('login')->with('msg', ['type' => 'danger', 'body' => 'Logear usuario ']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}