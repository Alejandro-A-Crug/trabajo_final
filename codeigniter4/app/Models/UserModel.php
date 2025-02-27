<?php  

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model to keep track of user related operations
 * 
 * @package App\Models
 */
class UserModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected  $allowedFields = ['nombre','contraseña','epoca','rol','borrado_en'];
    /**
 * 
 * @param string $nombre
 * @return array |null 
 */


 /**
  * Return all instances of nombre that look like $nombre 
  * @param string $nombre
  * @return string 
  */
 public function findByNombre(string $nombre){
    return $this->where('nombre',$nombre)->first(); 
 }

 /**
  * filters users based on name, age, id, role, and deletion date
  * @param mixed $filters
  * @param int $perPage
  * 
  * @return string
  */
  public function getFilteredUsers($filters, $perPage, $orderBy = 'id', $orderDirection = 'asc') {
    $builder = $this->where('id !=', 0);
    $currentYear = date('Y');
    $isFiltered = false;

    // Aplicar filtros
    if (!empty($filters['id'])) {
        $builder->like('id', $filters['id']);
        $isFiltered = true;
    }

    if (!empty($filters['nombre'])) {
        $builder->like('nombre', $filters['nombre']);
        $isFiltered = true;
    }

    if (!empty($filters['epoca'])) {
        if ($filters['epoca'] === 'before') {
            $builder->where('epoca <', $currentYear);
        } elseif ($filters['epoca'] === 'after') {
            $builder->where('epoca >', $currentYear);
        }
        $isFiltered = true;
    }

    if (!empty($filters['rol'])) {
        $builder->where('rol', $filters['rol']);
        $isFiltered = true;
    }

    if (!empty($filters['borrado_en'])) {
        if ($filters['borrado_en'] === 'Not_Null') {
            $builder->where('borrado_en !=', null);
        } elseif ($filters['borrado_en'] === 'Null') {
            $builder->where('borrado_en', null); 
        }
        $isFiltered = true;
    }
    
   
    $allowedColumns = ['id', 'nombre', 'epoca', 'rol'];
    if (!in_array($orderBy, $allowedColumns)) {
        $orderBy = 'id';
    }

    $orderDirection = strtolower($orderDirection) === 'desc' ? 'desc' : 'asc';

   
    $builder->orderBy($orderBy, $orderDirection);

    return $builder->paginate($perPage);
}

 
}



