<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin_direktorat,kepala_direktorat,admin_pemeringkatan,fakultas,prodi,admin_hilirisasi,kepala_sub_direktorat,wr3,dosen,mahasiswa,validator',
        ];
    }
}
