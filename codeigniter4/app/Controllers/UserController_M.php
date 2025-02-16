<?php

namespace App\Controllers;

use App\Models\UserModel;


/**
 * User controller ( M from metronic)
 * 
 * Takes care of all crud user related operations
 * 
 * @package App\Controllers
 */
class UserController_M extends BaseController
{
/**
 * 
 * Shows the user list, now with with applied filters
 * 
 * Codeigniter views are considered of type string
 * 
 * @return string 
 */
public function index(){

    $userModel = new UserModel();

    $filters = [
        'id' => $this->request->getGet('id'),

        'nombre' => $this->request->getGet('nombre'),

        'epoca' => $this->request->getGet('epoca'),
      
        'rol' => $this->request->getGet('rol'),

        'borrado_en' => $this->request->getGet('borrado_en'),
        
    ];

    $perPage = 8;

    $data['users'] = $userModel->getFilteredUsers($filters, $perPage);
    $data['pager'] = $userModel->pager;

    return view('list_metronic', $data);

}

 /**
     * Creates or edits an user 
     *
     * @param int|null $id 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
public function saveUser($id = null)
{
    $userModel = new UserModel();
    helper (['form','url']);
    //Cargar datos en caso de edicion
    $data['user']= $id ? $userModel->find($id) : null;

    if($this->request->getMethod() == 'POST'){

    $validation = \Config\Services::validation();
    $validation->setRules([
        'name'=>'required|min_length[2]|max_length[100]',
        'year'=> 'required|min_length[1]|max_length[7]',
        'password' => 'required|min_length[8]',
        'confirm-password' => 'required|matches[password]',

    ]);

    if(!$validation->withRequest($this->request)->run()){
        $data['validation'] =$validation;
    } else {
        $userData = [
            'nombre' => $this->request->getPost('name'),
            'epoca' => $this->request->getPost('year'),
            'contraseña' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol' => 'lector',
            'borrado_en' => NULL
        ];

        if($id) {
            $userModel->update($id, $userData);
            $message = "Usuario actualizado correctamente";
        } else {
            $userModel->save($userData);
            $message = "usuario creado correctamente";
        }

        return redirect()->to("/metronic/userlist")->with("success", $message);
    }

}
return view('sign-up', $data);

}

/**
 * 
 * manages the delete option of the user, doing a soft deletion
 * @param mixed $id
 * 
 * @return \CodeIgniter\HTTP\RedirectResponse
 */
public function deleteUser($id){
    $userModel = new UserModel();

    $userData = [
        'borrado_en' => date('Y-m-d H:i:s')
    ];

    $userModel->update($id, $userData);

    return redirect()->to('/metronic/userlist')->with('success','User archived succesfully');

}


/**
 * takes user to login page
 * 
 * @return string
 */
public function login(){
    return view('sign-in');
}

/**
 * 
 * Takes care of the login process, validation, and sessions
 * 
 * @return \CodeIgniter\HTTP\RedirectResponse|string
 */
public function loginProcess()
{
    helper(['form','url']);
    $session = session();

    $rules = [
        'name' => 'required',
        'password' => 'required',
    ];

    if(!$this->validate($rules)){
        return view('sign-in', [
            'validation' => $this->validator, // Pasamos los errores de validación a la vista.
        ]);
    }

    $userModel = new UserModel();
    $user = $userModel->findByNombre($this->request->getPost('name')); 

    if (!$user) {
        return redirect()->to('metronic/login')->with('error', 'User not found');
    }

    if (!is_null($user['borrado_en'])) { // Si tiene una fecha en "borrado_en", no puede iniciar sesión
        return redirect()->to('metronic/login')->with('error', 'Account terminated, contact the admin');
    }

    if($user && password_verify($this->request->getPost('password'), $user['contraseña'])) {
        $session -> set([
            'id' => $user['id'],           // ID del usuario.
            'nombre' => $user['nombre'],       // Nombre del usuario.
            'isLoggedIn' => true,          // Bandera para indicar que está logueado.


        ]);
        return redirect()->to('metronic')->with('success', 'Succesful login');
    }

return redirect()->to('metronic/login')->with('error', 'Incorrect user or password');
}

/**
 * destroys the user session once logged out
 * 
 * @return \CodeIgniter\HTTP\RedirectResponse
 */
public function logout()
{
    $session = session();
    $session->destroy();
    return redirect()->to('metronic/login')->with('success', 'Session closed succesfully');
}

public function sessiontest(){
   

    $session = \Config\Services::session();
    $session->set('usuario_id','admin');

    print_r($session->get('usuario_id'));
}
}