<?php

namespace App\Controllers;

use App\Models\TimeModel;


class TimeController extends BaseController{

/**
 * Index function returns all Ages data into the list
 * 
 * @return string 
 */

public function index(){
    $timeModel = new TimeModel();
    $data['ages'] = $timeModel->findAll();
    return view('timezones_table', $data);
}
  /**
     * Stores or updates a new entry on the database
     *
     * @param int|null $id ID opcional de la edad a actualizar, pues sirve tanto como para crear como para editar
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
public function saveAge($id = null)
{
    $timeModel = new TimeModel();
    $data['age'] =$id ? $timeModel->find($id): null;

    if($this->request->getMethod() == 'POST'){
        //validation 
        $validation = \Config\Services::validation();
        $validation->setRules([
            'Year'=> 'required|max_length[5]',
            'Age'=> 'required|max_length[150]',
            'Significant_Event'=> 'required|max_length[250]',
        ]);

        if(!$validation->withRequest($this->request)->run()){
            $data['validation'] = $validation;
        } else {
            $ageData = [
                'Year'=>$this->request->getPost('Year'),
                'Age'=>$this->request->getPost('Age'),
                'Significant_Event'=>$this->request->getPost('Significant_Event'),
            ];
        }

        if($id){
            $timeModel->update($id,$ageData);
            $message = 'nueva época añadida correctamente';
        } else {
            $timeModel->save($ageData);
            $message = 'nueva época añadida correctamente';
        }

        return redirect()->to('/metronic/timezone')->with('success', $message);
    }
    return view('new_timezone', $data);
}



}

