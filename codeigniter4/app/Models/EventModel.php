<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class EventModel extends Model
{
 protected $table = 'dates';

 protected $primaryKey = 'PK_ID_EVENT';

 protected $returnType = 'array';

 protected $allowedFields = ['TITLE','START_DATE','END_DATE','DESCRIPTION_ES','DESCRIPTION_ENG','DELETION_DATE'] ;


 public function getEvents($start, $end)
 {
     return $this->where('START_DATE >=', $start)
                 ->where('END_DATE <=', $end)
                 ->findAll();
 }
 
}