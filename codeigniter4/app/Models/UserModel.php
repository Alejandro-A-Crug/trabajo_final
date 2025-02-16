<?php  

namespace App\Models;

USE CodeIgniter\Model;

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
 public function getFilteredUsers($filters, $perPage)
 {
     $query = $this; 
     $currentYear = date('Y'); 
 
     $isFiltered = false;

     if (!empty($filters['id'])) {
      $query->like('id', $filters['id']);
      $isFiltered = true;
    }
 
     if (!empty($filters['nombre'])) {
         $query->like('nombre', $filters['nombre']);
         $isFiltered = true;
     }
 
     if (!empty($filters['epoca'])) {
         if ($filters['epoca'] === 'before') {
             $query->where('epoca <', $currentYear);
         } elseif ($filters['epoca'] === 'after') {
             $query->where('epoca >', $currentYear);
         }
         $isFiltered = true;
     }
 
     if (!empty($filters['rol'])) {
         $query->where('rol', $filters['rol']);
         $isFiltered = true;
     }
 
     if (!empty($filters['borrado_en'])) {
         if ($filters['borrado_en'] === 'Null') {
             $query->where('borrado_en', null); 
         } elseif ($filters['borrado_en'] === 'Not_Null') {
             $query->where('borrado_en IS NOT NULL'); 
         }
         $isFiltered = true;
     }
 
   
     return $isFiltered ? $query->paginate($perPage) : $this->paginate($perPage);
 }
 
}



