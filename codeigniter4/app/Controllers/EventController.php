<?php
 
namespace App\Controllers;
 
use App\Models\EventModel;
 
class EventController extends BaseController
{
    public function calendar(){
        return view("calendar");
    }

    public function fetchEvents()
    {
        $eventModel = new EventModel();
        $events = $eventModel->findAll();
    
        $formattedEvents = array_map(function ($event) {
            return [
                'id'    => $event['PK_ID_EVENT'],  
                'title' => $event['TITLE'], 
                'start' => date('c', strtotime($event['START_DATE'])), // Formato ISO 8601
                'end'   => date('c', strtotime($event['END_DATE']))     // Formato ISO 8601
            ];
        }, $events);
    
        return $this->response->setJSON($formattedEvents);
    }
    

    public function addEvent()
    {
        if (!$this->validate([
            'title' => 'required|min_length[3]',
            'start' => 'required|valid_date',
            'end'   => 'required|valid_date'
        ])) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }
    
        $eventModel = new EventModel();
    
        $data = [
            'TITLE' => $this->request->getPost('title'),
            'START_DATE' => $this->request->getPost('start'),
            'END_DATE' => $this->request->getPost('end')
        ];
    
        if ($eventModel->insert($data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }
    

    public function deleteEvent($id)
{
    $eventModel = new EventModel();

    // Verificar si el evento existe
    $event = $eventModel->find($id);

    if (!$event) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Evento no encontrado'
        ]);
    }

    if ($eventModel->delete($id)) {
        return $this->response->setJSON(['status' => 'success']);
    } else {
        return $this->response->setJSON(['status' => 'error']);
    }
}

}