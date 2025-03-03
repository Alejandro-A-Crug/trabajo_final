<?php  

namespace App\Models;

USE CodeIgniter\Model;

class TimeModel extends Model{
 protected $table = "timezone";

 protected $primaryKey = "id";

 protected $allowedFields = ["Year","Age","Significant_Event","Deletion_Date"];



 public function getFilteredAges($filters,$perPage,$orderBy, $orderDirection){
    $query = $this;
    $currentYear = date("Y");
    $isFiltered = false;

    if (!empty($filters['id'])) {
        $query->like('id', $filters['id']);
        $isFiltered = true;
    }

    if(!empty($filters['Year'])) {
        if($filters['Year'] === 'before'){
            $query->where('Year <', $currentYear);
        }
        else if($filters['Year'] === 'after'){
            $query->where('Year >', $currentYear);
        }
        $isFiltered = true;
    }
    if (!empty($filters['Age'])) {
        $query->like('Age', $filters['Age']);
        $isFiltered = true;
    }
    if (!empty($filters['Significant_Event'])) {
        $query->like('Significant_Event', $filters['Significant_Event']);
        $isFiltered = true;
    }

    if (!empty($filters['Putdown_Date'])) {
        if ($filters['Putdown_Date'] === 'NULL') {
            $query->where('Deletion_Date', null); 
        } elseif ($filters['Putdown_Date'] === 'NOT_NULL') {
            $query->where('Deletion_Date IS NOT NULL'); 
        }
        $isFiltered = true;
    }
    $query->orderBy($orderBy, $orderDirection);

    return $isFiltered ? $query->paginate($perPage) : $this->paginate($perPage);
 }
}