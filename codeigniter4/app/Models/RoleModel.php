<?php  

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model {
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['Name', 'Privileges', 'Deletion_Date'];

    public function getRoles() {
        return $this->findAll();
    }

    public function getfilteredRoles($filters, $perPage, $orderBy = 'Name', $orderDirection = 'ASC') {
        $query = $this->table($this->table);
        $isFiltered = false;

        // Apply filters
        if (!empty($filters['name'])) {
            $query->like('Name', $filters['name']);
            $isFiltered = true;
        }
        if (!empty($filters['privileges'])) {
            $privilegesMap = [
                'Read only' => 'Reading',
                'ReadWrite' => 'ReadingWriting',
                'Admin' => 'Admin',
            ];
            if (isset($privilegesMap[$filters['privileges']])) {
                $query->where('Privileges', $privilegesMap[$filters['privileges']]);
            }
            $isFiltered = true;
        }
        if (!empty($filters['deletion'])) {
            if ($filters['deletion'] === 'Null') {
                $query->where('Deletion_Date', null);
            } elseif ($filters['deletion'] === 'Not_Null') {
                $query->where('Deletion_Date IS NOT NULL');
            }
            $isFiltered = true;
        }

        // Apply ordering
        $query->orderBy($orderBy, $orderDirection);

        // Return paginated results
        return $isFiltered ? $query->paginate($perPage) : $this->paginate($perPage);
    }
}