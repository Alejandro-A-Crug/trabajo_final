<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * UserController
 */
class UserController extends BaseController
{

   
    public function index()
    {
        $userModel = new UserModel();

        $filters = [
            'id' => $this->request->getGet('id'),

            'nombre' => $this->request->getGet('nombre'),

            'epoca' => $this->request->getGet('epoca'),
          
            'rol' => $this->request->getGet('rol'),

            'borrado_en' => $this->request->getGet('borrado_en'),
            




        ];
        $data['users'] = $userModel->getFilteredUsers($filters, 3); 
        $data['pager'] = $userModel->pager; 
        return view('list', $data);
    }

public function saveUser($id = null)
{
    $userModel = new UserModel();
    helper (['form','url']);
    //Cargar datos en caso de edicion
    $data['user']= $id ? $userModel->find($id) : null;

    if($this->request->getMethod() == 'POST'){

    $validation = \Config\Services::validation();
    $validation->setRules([
        'nombre'=>'required|min_length[2]|max_length[100]',
        'epoca'=> 'required|min_length[1]|max_length[7]',
        'contraseña' => 'required|min_length[8]',

    ]);

    if(!$validation->withRequest($this->request)->run()){
        $data['validation'] =$validation;
    } else {
        $userData = [
            'nombre' => $this->request->getPost('nombre'),
            'epoca' => $this->request->getPost('epoca'),
            'contraseña' => password_hash($this->request->getPost('contraseña'), PASSWORD_DEFAULT),
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

        return redirect()->to("/usuarios")->with("success", $message);
    }



}
return view('registrar', $data);

}

public function deleteUser($id){
    $userModel = new UserModel();

    $userData = [
        'borrado_en' => date('Y-m-d H:i:s')
    ];

    $userModel->update($id, $userData);

    return redirect()->to('/')->with('success','persona archivada con éxito');

}



public function login(){
    return view('login');
}


public function processLogin()
{
    helper(['form', 'url']); // Carga los helpers necesarios para trabajar con formularios y URLs.
    $session = session(); // Inicia una sesión para el usuario. 

    $rules = [
        'nombre' => 'required', // El correo es obligatorio y debe ser válido.
        'contraseña' => 'required', // La contraseña es obligatoria.
    ];

    if (!$this->validate($rules)) {
        return view('login', [
            'validation' => $this->validator, // Pasamos los errores de validación a la vista.
        ]);
    }

    
    $userModel = new UserModel();
    $user = $userModel->findByNombre($this->request->getPost('nombre')); // Buscamos al usuario por su correo.

    if($user && password_verify($this->request->getPost('contraseña'), $user['contraseña'])) {
        $session -> set([
            'id' => $user['id'],           // ID del usuario.
            'nombre' => $user['nombre'],       // Nombre del usuario.
            'isLoggedIn' => true,          // Bandera para indicar que está logueado.

        ]);
        return redirect()->to('metronic')->with('success', 'Inicio de sesión exitoso.');
    }

return redirect()->to('login')->with('error', 'Correo o contraseña incorrectos.');
}


public function logout()
{
    $session = session();
    $session->destroy();
    return redirect()->to('/login')->with('success', 'Sesión cerrada con éxito.');
}


public function metronic(){
    return view('index');
}

public function calendar(){
    return view('calendar');
}

public function metronicUser(){
    return view('list_metronic');
}

}