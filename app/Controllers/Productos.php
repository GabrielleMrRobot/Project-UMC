<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;
//use App\Models\DetalleRolesPermisosModel;

class Productos extends BaseController

{
     protected $productos, $detalleRoles, $session;
     protected $reglas;

     public function __construct()
     {
        $this->productos = new ProductosModel();
        $this->unidades = new UnidadesModel();
        $this->categorias = new CategoriasModel();
       // $this->detalleRoles =  new DetalleRolesPermisosModel();
        $this->session = Session();
      
        helper(['form']);

        $this->reglas = [
          'codigo' => [
        'rules' => 'required|is_unique[productos.codigo]',
        'errors' => [
          'required' => 'El campo {field} es obligatorio.',
          'is_unique' => 'El campo {field} debe ser unico.',
        ]
      ],
        'nombre' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'El campo {field} es obligatorio.'
        ]
      ]
    ];
     }
        
     public function index($activo = 1)
     {

      /*$permiso = $this->detalleRoles->verificaPermisos($this->session->id_Rol, 'ProductosCatalogo');

      if(!$permiso){ 
        echo 'No tiene permiso'; 
        exit;
      } */
      
        $productos = $this->productos->where('activo',$activo)->findAll();
        $data = ['titulo' => 'Productos', 'datos' => $productos];
       
        
        echo view('header');
        echo view('productos/productos', $data);
        echo view('footer');
    
    }

    public function eliminados($activo = 0)
    {
       $productos = $this->productos->where('activo',$activo)->findAll();
       $data = ['titulo' => 'Productos eliminadas', 'datos' => $productos];

       echo view('header');
       echo view('productos/eliminados', $data);
       echo view('footer');
   
   }

    public function nuevo()
    {
      $unidades = $this->unidades->where('activo', 1)->findAll();
      $categorias = $this->categorias->where('activo', 1)->findAll();


      $data = ['titulo' => 'Agregar producto' , 'unidades' => $unidades, 'categorias' => $categorias];
      echo view('header');
      echo view('productos/nuevo', $data);
      echo view('footer');

    }

    public function insertar()
    {
      if($this->request->getMethod() == "post" && $this->validate($this->reglas)){ 

      $this->productos->save([
        'codigo' => $this->request->getPost('codigo'),  
        'nombre' => $this->request->getPost('nombre'), 
        'precio_venta' => $this->request->getPost('precio_venta'),  
        'precio_compra' => $this->request->getPost('precio_compra'),  
        'stock_minimo' => $this->request->getPost('stock_minimo'),  
        'inventariable' => $this->request->getPost('inventariable'),
        'id_unidad' => $this->request->getPost('id_unidad'),    
        'id_categoria' => $this->request->getPost('id_categoria')]);

        $id = $this->productos->insertID();

       /* $validacion = $this->validate([
          'img_producto' => [
            'uploaded[img_producto]',
            'mime_in[img_producto,image/jpg,image/jpeg]',
            'max_size[img_producto, 4096]'
          ]
          ]);
  
        if($validacion){
  
          $ruta_logo = "images/productos".$id.".jpg";
  
          if(file_exists($ruta_logo)){
            unlink($ruta_logo);
          }
          $img = $this->request->getFile('img_producto');
          $img->move('./images/productos', $id.'.jpg');
        } else {
          echo 'ERROR en la validacion';
          exit;
        }*/



      return redirect()->to(base_url().'/productos');
      } else {
  
        $unidades = $this->unidades->where('activo', 1)->findAll();
        $categorias = $this->categorias->where('activo', 1)->findAll();
        $data = ['titulo' => 'Agregar producto' , 'unidades' => $unidades, 'categorias' => $categorias, 
        'validation' => $this->validator];

      echo view('header');
      echo view('productos/nuevo', $data);
      echo view('footer');
      }
      
    }

    public function editar($id)
    {
      $unidades = $this->unidades->where('activo', 1)->findAll();
      $categorias = $this->categorias->where('activo', 1)->findAll();
      $producto = $this->productos->where('id', $id)->first();
      $data = ['titulo' => 'Editar producto' , 'unidades' => $unidades, 'categorias' => $categorias, 
      'producto' => $producto];

      echo view('header');
      echo view('productos/editar', $data);
      echo view('footer');

    }

    public function actualizar()
    {


      $this->productos->update($this->request->getPost('id'), [
        'codigo' => $this->request->getPost('codigo'),  
        'nombre' => $this->request->getPost('nombre'), 
        'precio_venta' => $this->request->getPost('precio_venta'),  
        'precio_compra' => $this->request->getPost('precio_compra'),  
        'stock_minimo' => $this->request->getPost('stock_minimo'),  
        'inventariable' => $this->request->getPost('inventariable'),
        'id_unidad' => $this->request->getPost('id_unidad'),    
        'id_categoria' => $this->request->getPost('id_categoria')]);

      return redirect()->to(base_url().'/productos');
    }

    public function eliminar($id)
    {
      $this->productos->update($id, ['activo' => 0]);
      return redirect()->to(base_url().'/productos');
    }

    public function reingresar($id)
    {
      $this->productos->update($id, ['activo' => 1]);
      return redirect()->to(base_url().'/productos');
    }



   public function buscarPorCodigo($codigo){
    
    $this->productos->select('*');
    $this->productos->where('codigo', $codigo);
    $this->productos->where('activo', 1);
    $datos = $this->productos->get()->getRow();

    $res['existe'] = false;
    $res['datos'] = '';
    $res['error'] = '';

    if($datos){
          $res['datos'] = $datos;
          $res['existe'] = true;
    } else {
      $res['error'] = 'No existe el producto';
      $res['existe']= false;

    }
       echo json_encode($res);

   }

public function autocompleteData(){
      $returnData = array();
      
      $valor = $this->request->getGet('term');
      
      $productos = $this->productos->like('codigo', $valor)->where('activo', 1)->findAll();
      if(!empty($productos)){
          foreach($productos as $row) {
              $data['id'] = $row['id'];
              $data['value'] = $row['codigo'];
              $data['label'] = $row['codigo'] .  ' - ' .$row['nombre'];
              array_push($returnData, $data);
          }
      }
      echo json_encode($returnData);
      }

      function muestraCodigos($id_venta){
        $data['id_venta'] = $id_venta;
        echo view('header');
        echo view('productos/ver_codigos');
        echo view('footer');
    } 

      
      public function generaBarras()
      { 
        
        $pdf = new \FPDF('P', 'mm', 'letter' );
        $pdf->AddPage();
        $pdf->SetMargins(10,10,10);
        $pdf->SetTitle("Codigos de barras");
        
        $productos = $this->productos->where('activo', 1)->findAll();
        foreach ($productos as $producto)  {
          $codigo = $producto ['codigo'];	
        
          $generaBarra = new \barcode_genera();
          $generaBarra->barcode("images/barcode/" .$codigo . ".png", $codigo, 20, "horizonal", "code128", true);
          $pdf->Image("images/barcode/" .$codigo ." .png");
          unlink("images/barcode/".$codigo."png");

        }
      
        $this->response>setHeader('Content-Type', 'application/pdf');
        $pdf->Output('Codigo.pdf','I');
      }
        
      function mostrarMinimos(){

        echo view('header');
        echo view('productos/ver_minimos');
        echo view('footer');
        } 
        public function generaMinimosPdf()
        { 
          
          $pdf = new \FPDF('P', 'mm', 'letter' );
          $pdf->AddPage();
          $pdf->SetMargins(10, 10, 10);
          $pdf->SetTitle("Productos con stock minimo");
          $pdf->SetFont('Arial','B',10);

          $pdf->Image("images/logo.png", 10, 5, 20);
            
            $pdf->Cell(0, 5, utf8_decode("Reporte de producto con stock minimo"), 0, 1, 'C');
        
            $pdf->Ln(10);
        
        
            $pdf->Cell(40, 5, utf8_decode("Codigo"), 1, 0, 'C');
            $pdf->Cell(85, 5, utf8_decode("Nombre"), 1, 0, 'C');
            $pdf->Cell(30, 5, utf8_decode("Existencias"), 1, 0, 'C');
            $pdf->Cell(30, 5, utf8_decode("Stock minimos"), 1, 1, 'C');
            $datosProductos = $this->productos->getProductosMinimo();
        
            foreach ($datosProductos as $producto) {
                
                $pdf->Cell(40, 7, $producto['codigo'], 1, 0,'C');
                $pdf->Cell(85,  7, utf8_decode($producto ['nombre']), 1, 0,'C') ;
                $pdf->Cell(30,  7, $producto['existencias'], 1, 0,'C');
                $pdf->Cell(30,  7 , $producto['stock_minimo'], 1, 1,'C');
                
            }
        
        
          $this->response->setHeader('Content-Type', 'application/pdf');
          $pdf->Output('ProductoMinimo.pdf','I');
        }
        
}