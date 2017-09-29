<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->blade->view('home/home');
	}

	public function usuarios()
	{
		$usuarios = Usuario::all();
		$this->blade->view('home/usuarios', compact('usuarios'));
	}

	public function usuario($idusuario)
	{
		$usuario = Usuario::find($idusuario);
		$this->blade->view('home/usuario', compact('usuario'));
	}

	public function clientes()
	{
		$clientes = Cliente::all();
		$this->blade->view('home/clientes', compact('clientes'));
	}

	public function cliente($idcliente)
	{
		$cliente = Cliente::find($idcliente);
		$this->blade->view('home/cliente', compact('cliente'));
	}
}
