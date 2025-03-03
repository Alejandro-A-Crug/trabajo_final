<?php

namespace App\Controllers;

use App\Models\TimeModel;

class TimeController extends BaseController
{
    /**
     * Index function returns all Ages data into the list
     * 
     * @return string 
     */
    public function index() {
        $request = service('request'); // Get the request instance
        $timeModel = new TimeModel();

        $filters = [
            'id' => $this->request->getGet('IdInput'),
            'Year' => $this->request->getGet('YearInput'),
            'Age' => $this->request->getGet('AgeInput'),
            'Significant_Event' => $this->request->getGet('SE_Input'),
            'Putdown_Date' => $this->request->getGet('DeleteInput'),
        ];

        // Get order parameters
        $orderBy = $this->request->getGet('orderBy') ?? 'id'; // Default order by 'id'
        $orderDirection = $this->request->getGet('orderDirection') ?? 'asc'; // Default order direction

        $perPage = $request->getGet('perPage') ?? 8;
        $data['perPage'] = $perPage; // Pass perPage to the view
        $data['ages'] = $timeModel->getFilteredAges($filters, $perPage, $orderBy, $orderDirection);
        $data['pager'] = $timeModel->pager;

        $data['orderBy'] = $orderBy;
        $data['orderDirection'] = $orderDirection;
        $data['request'] = $request->getGet();

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
        helper(['form', 'url']);

        if($id){
            $timezone = $timeModel ->find($id);

            if($timezone && $timezone['Deletion_Date']){
                return redirect()->to("/metronic/timezone")->with("error", "Cannot edit a deleted timezone.");
            }

            $data['age'] = $timezone;
        } else {
            $data['age'] = null;
        }
        // Load the selected language from POST data
        $language = $this->request->getPost('language') ?? 'en'; // Default to English
        $this->setLanguage($language);



        if ($this->request->getMethod() == 'POST') {
            // Validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                'Year' => 'required|max_length[5]|numeric',
                'Age' => 'required|max_length[150]',
                'Significant_Event' => 'required|max_length[250]',
            ]);

            $ageData = []; // Initialize the variable before validation

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
                    $message = lang('Messages.timezone_updated'); // Use language file for messages
                } else {
                    $timeModel->save($ageData);
                    $message = lang('Messages.timezone_added'); // Use language file for messages
                }

                return redirect()->to('/metronic/timezone')->with('success', $message);
            }
        }

        return view('new_timezone', $data);
    }

    public function deleteAge($id) {
        $timeModel = new TimeModel();

        $age = $timeModel->find($id);

        if (!$age) {
            return redirect()->to('/metronic/timezone')->with('error', 'Time not found.');
        }

        $ageData = [
            'Deletion_Date' => $age['Deletion_Date'] ? NULL : date('Y-m-d H:i:s')
        ];

        $timeModel->update($id, $ageData);

        return redirect()->to('/metronic/timezone')->with('success', $age['Deletion_Date'] ?'Timezone archived successfully' : 'Timezone restoredsuccessfully'); // Use language file for messages
    }

    private function setLanguage($language)
    {
        // Set the language for validation messages
        \Config\Services::language()->setLocale($language);
    }
}