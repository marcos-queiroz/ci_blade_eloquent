<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Usuario extends Eloquent {

    protected $primaryKey = 'id';
    protected $table = 'usuarios';

    public $timestamps = false;

    // relacionamento entre usuario e cliente
    function clientes ()
    {
        return $this->hasMany('Cliente', 'idusuario', 'id');
    }

}

class Cidade extends Eloquent {

    protected $primaryKey = 'id';
    protected $table = 'cidades';

    public $timestamps = false;

}

class Cliente extends Eloquent {

    protected $primaryKey = 'id';
    protected $table = 'clientes';

    public $timestamps = false;

    // relacionamento entre cliente e usuario
    function usuario()
    {
        return $this->belongsTo('Usuario', 'idusuario', 'id');
    }

    // relacionamento entre cliente e cidade
    function cidade()
    {
        return $this->belongsTo('Cidade', 'idcidade', 'id');
    }

}
