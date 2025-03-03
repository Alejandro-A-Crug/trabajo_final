<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;



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
public function index() {
    $request = service('request'); //Obtener request para ordenacion
    $userModel = new UserModel();

    $filters = [
        'id' => $request->getGet('id'),
        'nombre' => $request->getGet('nombre'),
        'epoca' => $request->getGet('epoca'),
        'rol' => $request->getGet('rol'),
        'borrado_en' => $request->getGet('borrado_en'),
    ];

    // Ordenacion
    $orderBy = $request->getGet('orderBy') ?? 'id'; 
    $orderDirection = $request->getGet('orderDirection') ?? 'asc'; 

    $perPage = $request->getGet('perPage') ?? 8;
    $data['perPage'] = $perPage; // Pasar perpage
    $data['orderBy'] = $orderBy;
    $data['orderDirection'] = $orderDirection;
    $data['users'] = $userModel->getFilteredUsers($filters, $perPage, $orderBy, $orderDirection);
    $data['pager'] = $userModel->pager;

    // Pasar request
    $data['request'] = $request->getGet();

    return view('list_metronic', $data);
}

public function displayUser(){
    return view('view_user');
}

 /**
     * Creates or edits an user 
     *
     * @param int|null $id 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */public function saveUser($id = null)
{
    $userModel = new UserModel();
    $roleModel = new RoleModel();
    helper(['form', 'url']);

    $roles = $roleModel->findAll();
    $data['roles'] = $roles;
    
    // is there an id?
    if ($id) {
        $user = $userModel->find($id);

        // is user deleted?
        if ($user && $user['borrado_en']) {
            return redirect()->to("/metronic/userlist")->with("error", "Cannot edit a deleted user.");
        }

        $data['user'] = $user;
    } else {
        $data['user'] = null;
    }

    // Load language
    $language = $this->request->getPost('language') ?? 'en'; // Default to English
    $this->setLanguage($language);

    if ($this->request->getMethod() == 'POST') {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[2]|max_length[100]',
            'year' => 'required|min_length[1]|max_length[7]',
            'password' => 'required|min_length[8]',
            'confirm-password' => 'required|matches[password]',
            'role' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $data['validation'] = $validation;
        } else {
            $userData = [
                'nombre' => $this->request->getPost('name'),
                'epoca' => $this->request->getPost('year'),
                'contraseña' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'rol' => $this->request->getPost('role'), // Get the selected role
                'borrado_en' => NULL
            ];

            if ($id) {
                $userModel->update($id, $userData);
                $message = "User updated correctly";
            } else {
                $userModel->save($userData);
                $message = "User created correctly";
            }

            return redirect()->to("/metronic/userlist")->with("success", $message);
        }
    }

    return view('sign-up', $data);
}


private function setLanguage($language)
{
    // Set the language for validation messages
    \Config\Services::language()->setLocale($language);
}

public function visualize($id){
    $userModel = new UserModel();
    $user = $userModel->find($id);

    if (!$user) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User not found");
    }

    return view('view_user', ['user' => $user]);
}

public function visualizeSession(){
   
    return view('view_user_session');
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

    // Obtener el usuario actual
    $user = $userModel->find($id);

    if (!$user) {
        return redirect()->to('/metronic/userlist')->with('error', 'User not found.');
    }

    // Si el usuario está eliminado, restaurarlo. Si no, archivarlo.
    $userData = [
        'borrado_en' => $user['borrado_en'] ? NULL : date('Y-m-d H:i:s')
    ];

    $userModel->update($id, $userData);

    return redirect()->to('/metronic/userlist')->with('success', $user['borrado_en'] ? 'User restored successfully' : 'User archived successfully');
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

    $language = $this->request->getPost('language') ?? 'en'; // Idioma predeterminado
    $this->setLanguage($language); // Establecer el idioma para los mensajes de validación

    $rules = [
        'name' => 'required',
        'password' => 'required',
    ];

    if (!$this->validate($rules)) {
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

    if ($user && password_verify($this->request->getPost('password'), $user['contraseña'])) {
        $this->session->set([
            'id' => $user['id'],           
            'nombre' => $user['nombre'],
            'rol' => $user['rol'],   
            'tiempo' => $user['epoca'],    
            'isLoggedIn' => true,
        ]);



        return redirect()->to('metronic')->with('success', 'Successful login');
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
    
    // Debugging: Check session data before destroying
    log_message('debug', 'Before logout: ' . print_r($session->get(), true));
    
    $session->destroy();
    
    // Debugging: Check session data after destroying
    log_message('debug', 'After logout: ' . print_r($session->get(), true));
    
    return redirect()->to('metronic/login')->with('success', 'Session closed successfully');
}

public function checkSession()
{
    $session = session();
    
    if ($session->has('isLoggedIn')) {
        return "User is still logged in";
    } else {
        return "Session has been destroyed";
    }
}



}