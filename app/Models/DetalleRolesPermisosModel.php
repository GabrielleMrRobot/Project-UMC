<?php


namespace App\Models;
use CodeIgniter\Model;

class DetalleRolesPermisosModel extends Model
{
    protected $table      = 'detalle_roles_permisos';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_rol', 'id_permiso'];

    // Dates
    protected $useTimestamps =  true;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;

    public function verificaPermisos($idRol, $permiso)
    {
        $tieneAcceso = false;
        $this->select('*');
        $this->join('permisos', 'detalle_roles_permisos.id_permiso = permisos.id');
        $existe = $this->where(['id_rol' => $idRol, 'permisos.nombre' => $permiso])->first();


        if($existe != null){
            $tieneAcceso = true;
        }
        return $tieneAcceso;
    }
}