<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    protected $primaryKey = 'id';

    protected $allowedFields = ['Title','Year','Level_Controversy','Deletion_Time'] ;

    public function getFilteredNews($filters,$perPage){
        $query = $this;
        $isFiltered = false;

        if(!empty($filters['Title'])){
            $query->like('Title', $filters['Title']);
            $isFiltered = true;
        }

        if(!empty($filters['Age'])){
            if($filters['Age'] === 'Prehistory'){
                $query->where('Year <', -3500);
            }
            else if($filters['Age'] === 'Ancient'){
                $query->where('Year >=', -3500)->where('Year <=', 476);
            }
            else if($filters['Age'] === 'Middle'){
                $query->where('Year >=', 477)->where('Year <=', 1453);
            }
            else if($filters['Age'] === 'Modern'){
                $query->where('Year >=', 1454)->where('Year <=', 1789);
            }
            else if($filters['Age'] === 'Contemporary'){
                $query->where('Year >=', 1790)->where('Year <=', 2042);
            }
            else if($filters['Age'] === 'Post-Contemporary'){
                $query->where('Year >=', 2043)->where('Year <=', 2175);
            }
            else if($filters['Age'] === 'Post-Divine'){
                $query->where('Year >=', 2176)->where('Year <=', 2344);
            }
            else if($filters['Age'] === 'Final'){
                $query->where('Year >=', 2345)->where('Year <=', 4566);
            }
            $isFiltered = true;
        }

        if(!empty($filters['Controversy'])){
            if($filters['Controversy'] === 'Low'){
                $query->where('Level_Controversy', 'Low'); 
            }
            else if($filters['Controversy'] === 'Medium'){
                $query->where('Level_Controversy', 'Medium'); 
            }
            else if($filters['Controversy'] === 'High'){
                $query->where('Level_Controversy', 'High'); 
            }
            $isFiltered = true;
        }

        if(!empty($filters['Status'])){
            if($filters['Status'] === 'Low'){
                $query->where('Deletion_Time', null); 
            }
            else if($filters['Status'] === 'Medium'){
                $query->where('Deletion_Date IS NOT NULL'); 
            }
            $isFiltered = true;
        }
        return $isFiltered ? $query->paginate($perPage) : $this->paginate($perPage);
    }
}