<?php


namespace App\Models;
use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table      = 'configuracion';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useSoftUpdates = false;
    protected $useSoftCreates = false;

    protected $allowedFields = ['nombre', 'valor'];

    // Dates
    protected $useTimestamps =  true;
    protected $createdField = '';
    protected $updatedField = '';
    protected $deletedField = '';


    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
}