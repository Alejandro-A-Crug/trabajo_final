<?php

namespace App\Controllers;

use App\Models\RoleModel;

class RoleController extends BaseController {

    public function index() {
        $request = service('request'); // Get the request instance
        $roleModel = new RoleModel();
     
        // Capture filter parameters
        $filters = [
            'name' => $this->request->getGet('name'),
            'privileges' => $this->request->getGet('privileges'),
            'deletion' => $this->request->getGet('deletion'),
        ];
    
        $perPage = 5;
    
        // Get order parameters from the request
        $orderBy = $this->request->getGet('order_by') ?? 'Name';
        $orderDirection = $this->request->getGet('order_direction') ?? 'ASC';
    
        // Get filtered and ordered roles
        $data['roles'] = $roleModel->getfilteredRoles($filters, $perPage, $orderBy, $orderDirection);
        $data['pager'] = $roleModel->pager;
        $data['currentOrderBy'] = $orderBy;
        $data['currentOrderDirection'] = $orderDirection;

        $data['request'] = $request->getGet();
    
        return view('roles_table', $data);
    }

    public function saveRole($id = null) {
        $roleModel = new RoleModel();
        helper(['form', 'url']);
        $data['role'] = $id ? $roleModel->find($id) : null;

        if($id){
            $role = $roleModel->find($id);

            if($role && $role['Deletion_Date']){
                return redirect()->to("/metronic/roles")->with("error", "Cannot edit a deleted role.");
            }

            $data['role'] = $role;
        } else {
            $data['role'] = null;
        }

        // Load the selected language from POST data
        $language = $this->request->getPost('language') ?? 'en'; // Default to English
        $this->setLanguage($language);

        if ($this->request->getMethod() == 'POST') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $data['validation'] = $validation;
            } else {
                $roleData = [
                    'Name' => $this->request->getPost('name'),
                    'Privileges' => $this->request->getPost('PrivilegeSelect'),
                ];

                if ($id) {
                    $roleModel->update($id, $roleData);
                    $message = lang('Messages.role_updated'); // Use language file for messages
                } else {
                    $roleModel->save($roleData);
                    $message = lang('Messages.role_created'); // Use language file for messages
                }

                return redirect()->to('metronic/roles')->with('success', $message);
            }
        }
        return view('create_role', $data);
    }

    public function deleteRole($id) {
        $roleModel = new RoleModel();

        $role = $roleModel->find($id);

        if(!$role){
            return redirect()->to('/metronic/roles')->with('error', 'Role not found.');
        }

        $roleData = [
            'Deletion_Date' =>$role['Deletion_Date'] ? NULL : date('Y-m-d H:i:s')
        ];

        $roleModel->update($id, $roleData);

        return redirect()->to('/metronic/roles')->with('success', $role['Deletion_Date'] ? 'Role restored successfully' : 'Role archived successfully'); // Use language file for messages
    }

    private function setLanguage($language) {
        // Set the language for validation messages
        \Config\Services::language()->setLocale($language);
    }
}