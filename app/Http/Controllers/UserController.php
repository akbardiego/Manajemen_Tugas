<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index(){
        $data = array(
            'title'             => 'Data User',
            'menuAdminUser'     => 'active',
            'user'              => User::orderBy('jabatan','asc')->get(),
        );
        return view('admin/user/index',$data);
    }

    public function create(){
        $data = array(
            'title'             => 'Tambah Data User',
            'menuAdminUser'     => 'active',
        );
        return view('admin/user/create',$data);
    }

    public function store(Request $request){
        $request->validate([
            'nama'          => 'required',
            'email'         => 'required|unique:users,email',
            'jabatan'       => 'required',
            'password'       => 'required|confirmed|min:8',
        ],[
            'nama.required'         => 'Nama Tidak Boleh Kosong',
            'email.required'        => 'Email Tidak Boleh Kosong',
            'email.unique'          => 'Email Sudah Ada',
            'jabatan.required'      => 'Jabatan Harus Di Pilih',
            'password.required'     => 'Password Tidak Boleh Kosong',
            'password.confirmed'    => 'Password konfirmasi tidak sama',
            'password.min'          => 'Password Minimal 8 Karakter',
        ]);

        $user = new User;
        $user->nama         = $request->nama;
        $user->email         = $request->email;
        $user->jabatan         = $request->jabatan;
        $user->password         = Hash::make($request->password);
        $user->is_tugas         = false;
        $user->save();

        return redirect()->route('user')->with('success','Data Berhasil Ditambahkan');
    }

    public function edit($id){
        $data = array(
            'title'             => 'Edit Data User',
            'menuAdminUser'     => 'active',
            'user'              =>  User::findorFail($id),
        );
        return view('admin/user/edit',$data);
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama'          => 'required',
            'email'         => 'required|unique:users,email,'.$id,
            'jabatan'       => 'required',
            'password'       => 'nullable|confirmed|min:8',
        ],[
            'nama.required'         => 'Nama Tidak Boleh Kosong',
            'email.required'        => 'Email Tidak Boleh Kosong',
            'email.unique'          => 'Email Sudah Ada',
            'jabatan.required'      => 'Jabatan Harus Di Pilih',
            'password.confirmed'    => 'Password konfirmasi tidak sama',
            'password.min'          => 'Password Minimal 8 Karakter',
        ]);

        $user = User::findOrFail($id);
        $user->nama         = $request->nama;
        $user->email         = $request->email;
        $user->jabatan         = $request->jabatan;
        if ($request->filled('password')) {
            $user->password         = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('user')->with('success','Data Berhasil Di Update');
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user')->with('success','Data Berhasil Di Hapus');
    }

    public function excel(){
        $filename = now()->format('d-m-Y_H.i.s');
        $data = array(
            'user'      => User::get(),
            'tanggal' => now()->format('d-m-Y'),
            'jam'   => now()->format('H.i.s'),
        );
        
        return Excel::download(new UserExport, 'DataUser_'.$filename.'.xlsx');
    }

    public function pdf(){
        $filename = now()->format('d-m-Y_H.i.s');
        $data = array(
            'user'      => User::get(),
            'tanggal' => now()->format('d-m-Y'),
            'jam'   => now()->format('H.i.s'),
        );
        
        $pdf = Pdf::loadView('admin/user/pdf', $data);
        return $pdf->download('DataUser_'.$filename.'.pdf');
    }

}
