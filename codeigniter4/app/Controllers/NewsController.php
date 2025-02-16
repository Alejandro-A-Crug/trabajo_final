<?php

namespace App\Controllers;

use App\Models\NewsModel;

class NewsController extends BaseController{

    public function index(){

        $newsModel = new NewsModel();

        $filters = [
            "Title"=> $this->request->getGet("Title"),

            "Age"=> $this->request->getGet("Age"),

            "Controversy"=> $this->request->getGet("Controversy"),

            "Status"=> $this->request->getGet("Status"),
        ];
        $perPage = 8;
        $data['news'] = $newsModel->getFilteredNews($filters,$perPage);
        $data['pager'] = $newsModel->pager;
        return view('news_list', $data);
    }

    public function saveNews($id = null){
       $newsModel = new NewsModel();
       helper(['form','url']);
       $data['new'] = $id ? $newsModel->find($id) : null;

       if($this->request->getMethod() == 'POST'){

        $validation = \Config\Services::validation();
        $validation-> setRules([
            'Title' => 'required|min_length[4]|max_length[95]',
            'Year' => 'required|numeric'
        ]);

        if(!$validation->withRequest($this->request)->run()){
            $data['validation'] = $validation;
        } else {
            $newsData = [
                'Title' => $this->request->getPost('Title'),
                'Year' => $this->request->getPost('Year'),
                'Level_Controversy'=> $this->request->getPost('Controversy'),
            ];

            if($id)
            {
                $newsModel->update($id,$newsData);
                $message = 'News updated correctly';
            } else {
                $newsModel->save( $newsData);
                $message = 'News created correctly';
            }

            return redirect()->to('metronic/news')->with('success', $message);
        }
       
       }
       return view('new_news', $data);
    }
 
    public function deleteNews($id){
        $newsModel = new NewsModel();
    
        $newsData = [
            
         'Deletion_Time' => date('Y-m-d H:i:s')
            
        ];
    
        $newsModel->update($id,$newsData);
    
        return redirect()->to('/metronic/news')->with('success','News archived succefully');
    }






}