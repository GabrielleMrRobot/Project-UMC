<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;

class Configuracion extends BaseController

{
     protected $configuracion;
     protected $reglas;

     public function __construct()
     {
        $this->configuracion = new ConfiguracionModel();
        helper(['form']);

        $this->reglas = [
          'tienda_nombre' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'El campo {field} es obligatorio.'
        ]
      ],
        'tienda_rif' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'El campo {field} es obligatorio.'
        ]
      ]
    ];


  }
        
     public function index($activo = 1)
     {
        $nombre = $this->configuracion->where('nombre', 'tienda_nombre')->first();
        $rif = $this->configuracion->where('nombre', 'tienda_rif')->first();
        $telefono = $this->configuracion->where('nombre', 'tienda_telefono')->first();
        $correo = $this->configuracion->where('nombre', 'tienda_correo')->first();
        $direccion = $this->configuracion->where('nombre', 'tienda_direccion')->first();
        $leyenda = $this->configuracion->where('nombre', 'ticket_leyenda')->first();
        $data = ['titulo' => 'Configuracion', 'nombre' => $nombre, 'rif' => $rif,
      'telefono' => $telefono, 'correo' => $correo, 'direccion' => $direccion, 'leyenda' => $leyenda];

        echo view('header');
        echo view('configuracion/configuracion', $data);
        echo view('footer');
    
    }



    public function editar($id, $valid=null)
    {
      $unidad = $this->configuracion->where('id', $id)->first();

      if($valid != null){
        $data = ['titulo' => 'Editar unidad', 'datos' => $unidad, 'validation' => $valid];
      } else {
        $data = ['titulo' => 'Editar unidad', 'datos' => $unidad];
      }

      
      echo view('header');
      echo view('configuracion/editar', $data);
      echo view('footer');

    }

    public function actualizar()
    {
      if($this->request->getMethod() == "post" && $this->validate($this->reglas)){
        
      $this->configuracion->whereIn('nombre', ['tienda_nombre'])->set(['valor' => $this->request->getPost('tienda_nombre')])
      ->update();
      $this->configuracion->whereIn('nombre', ['tienda_rif'])->set(['valor' => $this->request->getPost('tienda_rif')])
      ->update();
      $this->configuracion->whereIn('nombre', ['tienda_telefono'])->set(['valor' => $this->request->getPost('tienda_telefono')])
      ->update();
      $this->configuracion->whereIn('nombre', ['tienda_correo'])->set(['valor' => $this->request->getPost('tienda_correo')])
      ->update();
      $this->configuracion->whereIn('nombre', ['tienda_direccion'])->set(['valor' => $this->request->getPost('tienda_direccion')])
      ->update();
      $this->configuracion->whereIn('nombre', ['ticket_leyenda'])->set(['valor' => $this->request->getPost('ticket_leyenda')])
      ->update();


      return redirect()->to(base_url() . '/configuracion');
      } else {
        //return $this->editar($this->request->getPost('id'), $this->validator);
      }
    }

}