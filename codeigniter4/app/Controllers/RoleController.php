<?php

namespace App\Controllers;

use App\Models\RoleModel;

class RoleController extends BaseController{

public function index(){
    $roleModel = new RoleModel();
 
    $filters = [
        'name' => $this->request->getGet('name'),

        'privileges' => $this->request->getGet('privileges'),

        'deletion'=> $this->request->getGet('deletion'),
    ];

    $perPage = 4;

    $data['roles'] = $roleModel->getfilteredRoles($filters, $perPage);
    $data['pager'] = $roleModel->pager;

    return view('roles_table', $data);

    
}

public function saveRole($id = null){
    $roleModel = new RoleModel();
    helper(['form','url']);
    $data['role'] = $id ? $roleModel->find($id) : null;

    if($this->request->getMethod() == 'POST'){
        $validation = \Config\Services::validation();
        $validation -> setRules([
            'name'=> 'required|min_length[3]',
        ]);

        if(!$validation->withRequest($this->request)->run()){
            $data['validation'] = $validation;
        } else {
            $roleData = [
                'Name'=> $this->request->getPost('name'),
                'Privileges'=> $this->request->getPost('PrivilegeSelect'),
            ];

            if($id){
                $roleModel->update($id,$roleData);
                $message = 'Role updated succesfully';
            } else {
                $roleModel->save($roleData);
                $message = 'Role created succesfully';
            }

            return redirect()->to('metronic/roles')->with('success',$message);
        }
    }
    return view('create_role', $data);
}

public function deleteRole($id){
    $roleModel = new RoleModel();

    $roleData = [
        'Deletion_Date' => date('Y-m-d H:i:s')
    ];

    $roleModel->update($id, $roleData);

    return redirect()->to('/metronic/roles')->with('success','Role archived succesfully');

}






}
