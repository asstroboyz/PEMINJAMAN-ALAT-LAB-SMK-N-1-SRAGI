<?php

namespace App\Controllers;

use App\Libraries\Ciqrcode;
use App\Models\BalasanModel;
use App\Models\BarangModel;
use App\Models\detailPengadaanModel;
use App\Models\detailPermintaanModel;
use App\Models\InventarisModel;
use App\Models\KategoriBarangModel;
use App\Models\masterBarangModel;
use App\Models\MerkBarangModel;
use App\Models\MerkKategoriBarangModel;
use App\Models\PeminjamanDetailModel;
use App\Models\PeminjamanHeaderModel;
use App\Models\PengadaanModel;
use App\Models\pengecekanModel;
use App\Models\PermintaanModel;
use App\Models\Profil;
use App\Models\RuanganModel;
use App\Models\satuanModel;
use App\Models\TransaksiBarangModel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Kenjis\CI3Compatible\Core\CI_Input;
// use Myth\Auth\Entities\User;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;

class User extends BaseController
{
   protected $db;
    protected $builder;
    protected $BarangModel;
    protected $validation;
    protected $session;
    protected $masterBarangModel;
    protected $InventarisModel;
    protected $PermintaanModel;
    protected $PengadaanModel;
    protected $detailPengadaanModel;
    protected $detailPermintaanModel;
    protected $BalasanModel;
    protected $Profil;
    protected $pengecekanModel;
    protected $satuanModel;
    protected $TransaksiBarangModel;
    protected $PeminjamanHeaderModel;
    protected $PeminjamanDetailModel;
    protected $RuanganModel;
    protected $KategoriBarangModel;
    protected $MerkBarangModel;
    protected $MerkKategoriBarangModel;
    public function __construct()
    {
        $this->InventarisModel         = new InventarisModel();
        $this->PermintaanModel         = new PermintaanModel();
        $this->PengadaanModel          = new PengadaanModel();
        $this->detailPengadaanModel    = new detailPengadaanModel();
        $this->detailPermintaanModel   = new detailPermintaanModel();
        $this->BalasanModel            = new BalasanModel();
        $this->Profil                  = new Profil();
        $this->pengecekanModel         = new pengecekanModel();
        $this->BarangModel             = new BarangModel();
        $this->satuanModel             = new satuanModel();
        $this->TransaksiBarangModel    = new TransaksiBarangModel();
        $this->PeminjamanHeaderModel   = new PeminjamanHeaderModel();
        $this->PeminjamanDetailModel   = new PeminjamanDetailModel();
        $this->RuanganModel            = new RuanganModel();
        $this->db                      = \Config\Database::connect();
        $this->builder                 = $this->db->table('users');
        $this->validation              = \Config\Services::validation();
        $this->session                 = \Config\Services::session();
        // $this->ciqrcode                = new \App\Libraries\Ciqrcode();
        $this->masterBarangModel       = new masterBarangModel();
        $this->KategoriBarangModel     = new KategoriBarangModel();
        $this->MerkBarangModel         = new MerkBarangModel();
        $this->MerkKategoriBarangModel = new MerkKategoriBarangModel();
    }
    public function index()
    {

       
        $data = [
            'title' => 'Home'
        ];
        // dd($data);
        return view('User/Home/index', $data);
    }
    public function updatePassword($id)
    {
        $passwordLama = $this->request->getPost('passwordLama');
        $passwordbaru = $this->request->getPost('passwordBaru');
        $konfirm = $this->request->getPost('konfirm');
        if ($passwordbaru != $konfirm) {
            session()->setFlashdata('error-msg', 'Password Baru tidak sesuai');
            return redirect()->to(base_url('admin/tentang/' . $id));
        }

        $builder = $this->db->table('users');
        $this->builder->where('id', user()->id);
        $query = $this->builder->get()->getRow();
        $verify_pass = password_verify(base64_encode(hash('sha384', $passwordLama, true)), $query->password_hash);

        // dd($passwordbaru);
        if ($verify_pass) {
            $users = model(UserModel::class);
            $entity = new passwd();
            $entity->setPassword($passwordbaru);
            $hash  = $entity->password_hash;
            $users->update($id, ['password_hash' => $hash]);
            session()->setFlashdata('msg', 'Password berhasil Diubah');
            return redirect()->to('/user/tentang/' . $id);
        } else {
            session()->setFlashdata('error-msg', 'Password Lama tidak sesuai');
            return redirect()->to(base_url('user/tentang/' . $id));
        }
    }

    public function tentang()
    {

        $userlogin = user()->username;
        $userid = user()->id;
        $role = $this->db->table('auth_groups_users')->where('user_id', $userid)->get()->getRow();
        $role == '1' ? $role_echo = 'Admin' : $role_echo = 'User';



        $data = $this->db->table('pengaduan');
        $query1 = $data->where('id_user', $userid)->get()->getResult();
        $builder = $this->db->table('users');
        $builder->select('id,username,email,created_at,foto');
        $builder->where('username', $userlogin);
        $query = $builder->get();
        $semua = count($query1);
        $data = [
            'semua' => $semua,
            'user' => $query->getRow(),
            'title' => 'Home',
            'role' => $role_echo


        ];
        return view('user/profil/index', $data);
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
            'title' => 'Update Profile'
        ];
        // dd($data['user']);

        return view('user/profil/ubah_profil', $data);
    }

    public function simpanProfile($id)
    {
        $userlogin = user()->username;
        $builder = $this->db->table('users');
        $builder->select('*');
        $query = $builder->where('username', $userlogin)->get()->getRowArray();



        $foto = $this->request->getFile('foto');
        if ($foto->getError() == 4) {
            $this->profil->update($id, [
                'email' => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
            ]);
        } else {


            $nama_foto = 'UserFoto_' . $this->request->getPost('username') . '.' . $foto->guessExtension();
            if (!(empty($query['foto']))) {
                unlink('uploads/profile/' . $query['foto']);
            }
            $foto->move('uploads/profile', $nama_foto);

            $this->profil->update($id, [
                'email' => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
                'foto' => $nama_foto
            ]);
        }
        session()->setFlashdata('msg', 'Profil Pengaduan  berhasil Diubah');
        return redirect()->to('/user');
    }


    public function pengguna()
    {
        return view('user/pengguna');
    }

 public function peminjaman()
    {
        $status = $this->request->getGet('status') ?? 'all'; // ambil dari query param

        $builder = $this->PeminjamanHeaderModel
            ->select('peminjaman_header.*, users.username as peminjam, r.nama_ruangan as lokasi_pinjam')
            ->join('users', 'users.id = peminjaman_header.id_user', 'left')
            ->join('ruangan r', 'r.id = peminjaman_header.ruangan_id_pinjam', 'left')
            ->orderBy('peminjaman_header.tanggal_pinjam', 'desc');

        if ($status && $status != 'all') {
            $builder->where('peminjaman_header.status', $status);
        }

        $peminjamans = $builder->findAll();

        $data = [
            'title'       => 'Peminjaman Alat',
            'peminjamans' => $peminjamans,
            'status'      => $status,
        ];

        // dd($data);
        return view('User/Peminjaman/Index', $data);
    }




   
}
