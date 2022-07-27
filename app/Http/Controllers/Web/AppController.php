<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function __construct() {
        $this->pageProperty = array(
            'public' => array(
                'pageHeader' => 'publicHeader',
                'pageFooter' => 'publicFooter',
                'htmlDir' => 'web.public.html',
                'scriptDir' => 'web.public.script',
                'htmlUtilityDir' => 'utility.html',
                'scriptUtilityDir' => 'utility.script',
                'currentPage' => null,
            ),
            'admin' => array(
                'pageHeader' => 'adminHeader',
                'pageFooter' => 'adminFooter',
                'htmlDir' => 'web.admin.html',
                'scriptDir' => 'web.admin.script',
                'htmlUtilityDir' => 'utility.html',
                'scriptUtilityDir' => 'utility.script',
                'currentPage' => null,
            )
        );

        $this->links = array(
            'dashboard' => route('web.dashboard'),
            'user' => route('web.user'),
            'matakuliah' => route('web.matakuliah'),
            'kriteria' => route('web.kriteria'),
            'alternatif' => route('web.alternatif'),
            'login' => route('web.login'),
        );
    }

    public function index()
    {
        return $this->renderView('dashboard', 'admin');
    }

    public function user()
    {
        return $this->renderView('user', 'admin');
    }

    public function matakuliah() {
        return $this->renderView('matakuliah', 'admin');
    }

    public function kriteria() {
        return $this->renderView('kriteria', 'admin');
    }

    public function alternatif() {
        return $this->renderView('alternatif', 'admin');
    }

    public function login() {
        return $this->renderView('login', 'public');
    }

    private function renderView($mainContent, $pageType) {
        if($this->pageProperty[$pageType] === NULL) return redirect()->route('/notfound');

        $this->pageProperty[$pageType]['currentPage'] = $mainContent;
        return view($this->pageProperty[$pageType]['htmlUtilityDir'].'.content', array(
            'pageProperties' => $this->pageProperty[$pageType],
            'pageLinks' => $this->links,
        ));
    }
    
}
