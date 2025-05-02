<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index(){
        $data = array(
            'title'             => 'Data Tugas',
            'menuAdminTugas'     => 'active',
            'tugas'              => Tugas::with('user')->get(),
        );
        return view('admin/tugas/index',$data);
    }
}
