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

    $filters = [

        'id' => $this->request->getGet('IdInput'),
        'Year'=> $this->request->getGet('YearInput'),
        'Age'=> $this->request->getGet('AgeInput'),
        'Significant_Event'=> $this->request->getGet('SE_Input'),
        'Putdown_Date'=> $this->request->getGet('DeleteInput'),

    ];

    $perPage = 7;
    $data['ages'] = $timeModel->getFilteredAges($filters,$perPage);

    $data['pager'] = $timeModel->pager;


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
        $data['age'] = $id ? $timeModel->find($id) : null;
    
        if ($this->request->getMethod() == 'POST') {
            // Validación
            $validation = \Config\Services::validation();
            $validation->setRules([
                'Year' => 'required|max_length[5]',
                'Age' => 'required|max_length[150]',
                'Significant_Event' => 'required|max_length[250]',
            ]);
    
            $ageData = []; // Inicializar la variable antes de la validación
    
            if (!$validation->withRequest($this->request)->run()) {
                $data['validation'] = $validation;
            } else {
                $ageData = [
                    'Year' => $this->request->getPost('Year'),
                    'Age' => $this->request->getPost('Age'),
                    'Significant_Event' => $this->request->getPost('Significant_Event'),
                ];
    
                if ($id) {
                    $timeModel->update($id, $ageData);
                    $message = 'Timezone updated successfully';
                } else {
                    $timeModel->save($ageData);
                    $message = 'New timezone added successfully';
                }
    
                return redirect()->to('/metronic/timezone')->with('success', $message);
            }
        }
    
        return view('new_timezone', $data);
    }
    

public function deleteAge($id){
    $timeModel = new TimeModel();

    $ageData = [
        
     'Deletion_Date' => date('Y-m-d H:i:s')
        
    ];

    $timeModel->update($id,$ageData);

    return redirect()->to('/metronic/timezone')->with('success','Epoca con éxito');
}



}

