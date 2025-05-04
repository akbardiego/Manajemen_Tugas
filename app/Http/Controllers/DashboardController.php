<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = array(
            "title"             => "Dashboard",
            "menuDashboard"     => "active",
            "jumlahUser"        => User::count(),
            "jumlahAdmin"        => User::where('jabatan','Admin')->count(),
            "jumlahKaryawan"        => User::where('jabatan','Karyawan')->count(),
            "jumlahDitugaskan"        => User::where('jabatan','Karyawan')->where('is_Tugas',True)->count(),
            "jumlahBelumDitugaskan"        => User::where('jabatan','Karyawan')->where('is_Tugas',false)->count(),
        );

        return view('dashboard', $data);
    }
}
