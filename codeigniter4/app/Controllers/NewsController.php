<?php

namespace App\Controllers;

use App\Models\NewsModel;

class NewsController extends BaseController {

    public function index() {
        $request = service('request'); // Get the request instance
        $newsModel = new NewsModel();

        $filters = [
            "Title" => $this->request->getGet("Title"),
            "Age" => $this->request->getGet("Age"),
            "Controversy" => $this->request->getGet("Controversy"),
            "Status" => $this->request->getGet("Status"),
        ];

        $orderBy = $this->request->getGet('orderBy') ?? 'id'; 
        $orderDirection = $this->request->getGet('orderDirection') ?? 'asc'; 
        $perPage = 8;

        $data['orderBy'] = $orderBy;
        $data['orderDirection'] = $orderDirection;
        $data['news'] = $newsModel->getFilteredNews($filters, $perPage, $orderBy, $orderDirection);
        $data['pager'] = $newsModel->pager;

        $data['request'] = $request->getGet();

        return view('news_list', $data);
    }

    public function saveNews($id = null) {
        $newsModel = new NewsModel();
        helper(['form', 'url']);
        $data['new'] = $id ? $newsModel->find($id) : null;

        if($id){
            $new = $newsModel->find($id);

            if($new && $new['Deletion_Time']){
                return redirect()->to("/metronic/news")->with("error", "Cannot edit a deleted article.");
            }
            $data['new'] = $new;
            } else {
                $data['new'] = null;
            }

        // Load the selected language from POST data
        $language = $this->request->getPost('language') ?? 'en'; // Default to English
        $this->setLanguage($language);

        if ($this->request->getMethod() == 'POST') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'Title' => 'required|min_length[4]|max_length[95]',
                'Year' => 'required|numeric'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $data['validation'] = $validation;
            } else {
                $newsData = [
                    'Title' => $this->request->getPost('Title'),
                    'Year' => $this->request->getPost('Year'),
                    'Level_Controversy' => $this->request->getPost('Controversy'),
                ];

                if ($id) {
                    $newsModel->update($id, $newsData);
                    $message = lang('Messages.news_updated'); // Use language file for messages
                } else {
                    $newsModel->save($newsData);
                    $message = lang('Messages.news_created'); // Use language file for messages
                }

                return redirect()->to('metronic/news')->with('success', $message);
            }
        }
        return view('new_news', $data);
    }

    public function deleteNews($id) {
        $newsModel = new NewsModel();

        $new = $newsModel->find($id);

        if(!$new){
            return redirect()->to('metronic/news')->with('error', 'News not found');
        }

        $newsData = [
            'Deletion_Time' => $new['Deletion_Time'] ? NULL : date('Y-m-d H:i:s')
        ];

        $newsModel->update($id, $newsData);

        return redirect()->to('/metronic/news')->with('success', $new['Deletion_Time'] ? 'News restored successfully' : 'News archived successfully'); // Use language file for messages
    }

    private function setLanguage($language) {
        // Set the language for validation messages
        \Config\Services::language()->setLocale($language);
    }
}