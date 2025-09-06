<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\InventarisModel;
use App\Models\PengadaanModel;
use App\Models\detailPermintaanModel;
use App\Models\PermintaanModel;
use App\Models\Profil;
use Dompdf\Dompdf;
use Dompdf\Options;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\GroupModel;

class Administrator extends BaseController
{
    protected $db;
    protected $builder;
    protected $BarangModel;
    protected $PermintaanModel;
    protected $PengadaanModel;
    protected $detailPermintaanModel;
    public function __construct()
    {

        $this->Profil = new Profil;
        $this->PengadaanModel = new PengadaanModel();
        $this->BarangModel = new BarangModel();
        $this->InventarisModel = new InventarisModel();
        $this->PermintaanModel = new PermintaanModel();
        $this->detailPermintaanModel = new detailPermintaanModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // $data['title'] = 'User Profile ';
        $userlogin = user()->id;

        $data = $this->db->table('detail_permintaan_barang');
        // $builder->select('id,username,email,created_at,foto');

        $query1 = $data->where('id_user', $userlogin)->get()->getResult();
        $query2 = $data->where('id_user', $userlogin)->where('status', 'diproses')->get()->getResult();
        $query3 = $data->where('id_user', $userlogin)->where('status', 'selesai')->get()->getResult();
        // $query = $builder->get();
        // $query1 = $builder->where('status', 'diproses')->get()->getResult();
        $semua = count($query1);

        $data = [
            'semua' => $semua,
            'proses' => count($query2),
            'selesai' => count($query3),
            'title' => 'Home',
        ];
        return view('Administrator/Home/Index', $data);
    }
    public function profil()
    {
        $data['title'] = 'User Profile';
        $userlogin = user()->username;
        $userid = user()->id;

        // Mengambil data role dari tabel auth_groups_users
        $roleData = $this->db->table('auth_groups_users')->where('user_id', $userid)->get()->getRow();

        // Memeriksa apakah data role ditemukan
        if ($roleData) {
            $adminRoleId = 1;
            $petugasPengadaan = 2;
            $administratorId = 4; // ID untuk role Administrator

            // Menentukan status role berdasarkan ID role
            if ($roleData->group_id == $adminRoleId) {
                $role_echo = 'Admin';
            } elseif ($roleData->group_id == $petugasPengadaan) {
                $role_echo = 'Petugas Pengadaan';
            } elseif ($roleData->group_id == $administratorId) {
                $role_echo = 'Administrator';
            } else {
                $role_echo = 'Pegawai';
            }
        } else {
            // Jika data role tidak ditemukan, mengatur nilai default sebagai 'Pegawai'
            $role_echo = 'Pegawai';
        }

        // Mengambil data pengguna dari tabel 'users'
        $builder = $this->db->table('users');
        $builder->select('id, username, email, created_at, foto');
        $builder->where('username', $userlogin);
        $query = $builder->get();
        $user = $query->getRow();

        $data = [
            'user' => $user,
            'title' => 'Profil - BPS',
            'role' => $role_echo,
        ];

        return view('Administrator/Home/Profil', $data);
    }

    public function updatePassword($id)
    {
        $passwordLama = $this->request->getPost('passwordLama');
        $passwordbaru = $this->request->getPost('passwordBaru');
        $konfirm = $this->request->getPost('konfirm');

        if ($passwordbaru != $konfirm) {
            session()->setFlashdata('error-msg', 'Password Baru tidak sesuai');
            return redirect()->to(base_url('Administrator/profil/' . $id));
        }

        $builder = $this->db->table('users');
        $builder->where('id', user()->id);
        $query = $builder->get()->getRow();
        $verify_pass = password_verify(base64_encode(hash('sha384', $passwordLama, true)), $query->password_hash);

        if ($verify_pass) {
            $users = new UserModel();
            $entity = new \Myth\Auth\Entities\User();

            $entity->setPassword($passwordbaru);
            $hash = $entity->password_hash;
            $users->update($id, ['password_hash' => $hash]);
            session()->setFlashdata('msg', 'Password berhasil Diubah');
            return redirect()->to('/Administrator/profil/' . $id);
        } else {
            session()->setFlashdata('error-msg', 'Password Lama tidak sesuai');
            return redirect()->to(base_url('Administrator/profil/' . $id));
        }
    }

    public function profile($id)
    {
        $userlogin = user()->username;
        $builder = $this->db->table('users');
        $builder->select('username,email,created_at');
        $query = $builder->where('username', $userlogin)->get()->getRowArray();
        $data = [

            'user' => $query,
            'validation' => $this->validation,
            'title' => 'Update Profile',
        ];
        // dd($data['user']);

        return view('Administrator/Profil/Ubah_profil', $data);
    }

    public function simpanProfile($id)
    {
        $userlogin = user()->username;
        $builder = $this->db->table('users');
        $builder->select('*');
        $query = $builder->where('username', $userlogin)->get()->getRowArray();

        $foto = $this->request->getFile('foto');
        if ($foto->getError() == 4) {
            $this->Profil->update($id, [
                'email' => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
            ]);
        } else {

            $nama_foto = 'AdministratorFOTO' . $this->request->getPost('username') . '.' . $foto->guessExtension();
            if (!(empty($query['foto']))) {
                unlink('uploads/profile/' . $query['foto']);
            }
            $foto->move('uploads/profile', $nama_foto);

            $this->Profil->update($id, [
                'email' => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
                'foto' => $nama_foto,
            ]);
        }
        session()->setFlashdata('msg', 'Profil Administrator  berhasil Diubah');
        return redirect()->to(base_url('Administrator/profil/' . $id));
    }

    public function kelola_user()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        $groupModel = new GroupModel();

        foreach ($data['users'] as $row) {
            $dataRow['group'] = $groupModel->getGroupsForUser($row->id);
            $dataRow['row'] = $row;
            $data['row' . $row->id] = view('Administrator/User/Row', $dataRow);
        }
        $data['groups'] = $groupModel->findAll();
        $data['title'] = 'Daftar Pengguna';
        return view('Administrator/User/Index', $data);
    }

    public function tambah_user()
    {

        $data = [
            'title' => 'BPS - Tambah Users',
        ];
        return view('/Administrator/User/Tambah', $data);
    }

    public function changeGroup()
    {
        $userId = $this->request->getVar('id');
        $groupId = $this->request->getVar('group');
        $groupModel = new GroupModel();
        $groupModel->removeUserFromAllGroups(intval($userId));
        $groupModel->addUserToGroup(intval($userId), intval($groupId));
        return redirect()->to(base_url('/Administrator/kelola_user'));
    }

    public function changePassword()
    {
        $userId = $this->request->getVar('user_id');

        $password_baru = $this->request->getVar('password_baru');
        $userModel = new \App\Models\User();
        $user = $userModel->getUsers($userId);
        // $dataUser->update($userId, ['password_hash' => password_hash($password_baru, PASSWORD_DEFAULT)]);
        $userEntity = new User($user);
        $userEntity->password = $password_baru;
        $userModel->save($userEntity);
        return redirect()->to(base_url('Administrator/kelola_user'));
    }

    public function activateUser($id, $active)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user) {
            $userModel->update($id, ['active' => $active]);
            return redirect()->back()->with('success', 'Status pengguna berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }
    }
}
