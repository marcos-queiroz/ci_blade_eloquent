<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		return $this->blade->view('home/home');
	}

	public function usuarios()
	{
		$usuarios = Usuario::all();
		return $this->blade->view('home/usuarios', compact('usuarios'));
	}

	public function usuario($idusuario)
	{
		$usuario = Usuario::find($idusuario);
		return $this->blade->view('home/usuario', compact('usuario'));
	}

	public function clientes()
	{
		$clientes = Cliente::all();
		return $this->blade->view('home/clientes', compact('clientes'));
	}

	public function cliente($idcliente)
	{
		$cliente = Cliente::find($idcliente);
		return $this->blade->view('home/cliente', compact('cliente'));
	}
}
