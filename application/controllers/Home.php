<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
        $clientes = Cliente::all();
		$this->blade->view('home/clientes', compact('clientes'));
	}
}
