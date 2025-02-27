<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    protected $primaryKey = 'id';

    protected $allowedFields = ['Title','Year','Level_Controversy','Deletion_Time'] ;

    public function getFilteredNews($filters,$perPage,$orderBy = 'id', $orderDirection = 'asc'){
        $builder = $this->where('id !=', 0);
        $isFiltered = false;

        if(!empty($filters['Title'])){
            $builder->like('Title', $filters['Title']);
            $isFiltered = true;
        }

        if(!empty($filters['Age'])){
            if($filters['Age'] === 'Prehistory'){
                $builder->where('Year <', -3500);
            }
            else if($filters['Age'] === 'Ancient'){
                $builder->where('Year >=', -3500)->where('Year <=', 476);
            }
            else if($filters['Age'] === 'Middle'){
                $builder->where('Year >=', 477)->where('Year <=', 1453);
            }
            else if($filters['Age'] === 'Modern'){
                $builder->where('Year >=', 1454)->where('Year <=', 1789);
            }
            else if($filters['Age'] === 'Contemporary'){
                $builder->where('Year >=', 1790)->where('Year <=', 2042);
            }
            else if($filters['Age'] === 'Post-Contemporary'){
                $builder->where('Year >=', 2043)->where('Year <=', 2175);
            }
            else if($filters['Age'] === 'Post-Divine'){
                $builder->where('Year >=', 2176)->where('Year <=', 2344);
            }
            else if($filters['Age'] === 'Final'){
                $builder->where('Year >=', 2345)->where('Year <=', 4566);
            }
            $isFiltered = true;
        }

        if(!empty($filters['Controversy'])){
            if($filters['Controversy'] === 'Low'){
                $builder->where('Level_Controversy', 'Low'); 
            }
            else if($filters['Controversy'] === 'Medium'){
                $builder->where('Level_Controversy', 'Medium'); 
            }
            else if($filters['Controversy'] === 'High'){
                $builder->where('Level_Controversy', 'High'); 
            }
            $isFiltered = true;
        }

        if(!empty($filters['Status'])){
            if($filters['Status'] === 'Low'){
                $builder->where('Deletion_Time', null); 
            }
            else if($filters['Status'] === 'Medium'){
                $builder->where('Deletion_Date IS NOT NULL'); 
            }
            $isFiltered = true;
        }

        $allowedColumns = ['id', 'Title', 'Year', 'Level_Controversy'];
        if (!in_array($orderBy, $allowedColumns)) {
          $orderBy = 'id';
        
        }

        $orderDirection = strtolower($orderDirection) === 'desc' ? 'desc' : 'asc';

        $builder->orderBy($orderBy, $orderDirection);
        return $builder->paginate($perPage);
    }
}