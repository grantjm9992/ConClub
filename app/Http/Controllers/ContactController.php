<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use \App\Providers\TranslationProvider;
use Illuminate\Http\Request;

class ContactController extends BaseController
{

    public function __construct() {
        parent::__construct();
    }
    
    public function defaultAction() {
        $this->cont->body = view('contact/index');
        return $this->RenderView();
    }

}