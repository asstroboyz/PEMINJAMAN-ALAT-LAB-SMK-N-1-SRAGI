<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\InventarisModel;
use App\Models\PengadaanModel;
use App\Models\detailPermintaanModel;
use App\Models\detailPengadaanModel;

use App\Models\PermintaanModel;
use App\Models\Profil;
use Dompdf\Dompdf;
use Dompdf\Options;
use Myth\Auth\Models\UserModel;

class Pegawai extends BaseController
{
    protected $db;
    protected $builder;
    protected $BarangModel;
    protected $PermintaanModel;
    protected $PengadaanModel;
    protected $detailPermintaanModel;
    protected $detailPengadaanModel;
    public function __construct()
    {

        $this->Profil = new Profil;
        $this->PengadaanModel = new PengadaanModel();
        $this->detailPengadaanModel = new detailPengadaanModel();
        $this->BarangModel = new BarangModel();
        $this->InventarisModel = new InventarisModel();
        $this->PermintaanModel = new PermintaanModel();
        $this->detailPermintaanModel = new detailPermintaanModel();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    // public function index()
    // {
    //     // $data['title'] = 'User Profile ';
    //     $userlogin = user()->id;

    //     $data = $this->db->table('detail_permintaan_barang');
    //     // $builder->select('id,username,email,created_at,foto');

    //     $query1 = $data->where('id_user', $userlogin)->get()->getResult();
    //     $query2 = $data->where('id_user', $userlogin)->where('status', 'diproses')->get()->getResult();
    //     $query3 = $data->where('id_user', $userlogin)->where('status', 'selesai')->get()->getResult();
    //     // $query = $builder->get();
    //     // $query1 = $builder->where('status', 'diproses')->get()->getResult();
    //     $semua = count($query1);

    //     $data = [
    //         'semua' => $semua,
    //         'proses' => count($query2),
    //         'selesai' => count($query3),
    //         'title' => 'Home',
    //     ];
    //     return view('Pegawai/Profil/Home', $data);
    // }
    public function index()
    {
        $userlogin = user()->id;

        // Ambil semua data dari tabel detail_permintaan_barang
        $detailData = $this->db->table('detail_permintaan_barang')
            ->get()
            ->getResult();

        // Join tabel permintaan_barang dan detail_permintaan_barang
        $data = $this->db->table('permintaan_barang')
            ->join('detail_permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')
            ->where('permintaan_barang.id_user', $userlogin)
            ->get()
            ->getResult();

        // Hitung jumlah data dengan status 'belum diproses'
        $belumDiprosesCount = $this->db->table('permintaan_barang')
            ->join('detail_permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')
            ->where('permintaan_barang.id_user', $userlogin)
            ->where('detail_permintaan_barang.status', 'belum diproses')
            ->countAllResults();

        // Hitung jumlah data dengan status 'diproses'
        $diprosesCount = $this->db->table('permintaan_barang')
            ->join('detail_permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')
            ->where('permintaan_barang.id_user', $userlogin)
            ->where('detail_permintaan_barang.status', 'diproses')
            ->countAllResults();

        // Hitung jumlah data dengan status 'selesai'
        $selesaiCount = $this->db->table('permintaan_barang')
            ->join('detail_permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')
            ->where('permintaan_barang.id_user', $userlogin)
            ->where('detail_permintaan_barang.status', 'selesai')
            ->countAllResults();

        $semua = count($data);

        $data = [
            'semua' => $semua,
            'proses' => $diprosesCount,
            'selesai' => $selesaiCount,
            'belumDiproses' => $belumDiprosesCount,
            'detailData' => $detailData, // Tambahkan variabel detailData ke dalam data
            'title' => 'Home',
        ];

        return view('Pegawai/Profil/Home', $data);
    }




    public function profil()
    {

        $data['title'] = 'User Profile ';
        $userlogin = user()->username;
        $userid = user()->id;
        $role = $this->db->table('auth_groups_users')->where('user_id', $userid)->get()->getRow();
        $role == '1' ? $role_echo = 'Admin' : $role_echo = 'Pegawai'; // $data['title'] = 'User Profile ';
        $userlogin = user()->username;
        $userid = user()->id;

        // Mengambil data role dari tabel auth_groups_users
        $roleData = $this->db->table('auth_groups_users')->where('user_id', $userid)->get()->getRow();

        // Memeriksa apakah data role ditemukan
        if ($roleData) {

            $adminRoleId = 1;
            $petugasPengadaan = 2;

            // Menentukan status role berdasarkan ID role
            if ($roleData->group_id == $adminRoleId) {
                $role_echo = 'Admin';
            } elseif ($roleData->group_id == $petugasPengadaan) {
                $role_echo = 'Petugas Pengadaan';
            } else {
                $role_echo = 'Pegawai';
            }
        } else {
            // Jika data role tidak ditemukan, mengatur nilai default sebagai 'Pegawai'
            $role_echo = 'Pegawai';
        }


        $data = $this->db->table('permintaan_barang');
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
            'role' => $role_echo,

        ];
        return view('Pegawai/Profil/Index', $data);
    }

    public function updatePassword($id)
    {
        $passwordLama = $this->request->getPost('passwordLama');
        $passwordbaru = $this->request->getPost('passwordBaru');
        $konfirm = $this->request->getPost('konfirm');

        if ($passwordbaru != $konfirm) {
            session()->setFlashdata('error-msg', 'Password Baru tidak sesuai');
            return redirect()->to(base_url('Pegawai/profil/' . $id));
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
            return redirect()->to('/Pegawai/profil/' . $id);
        } else {
            session()->setFlashdata('error-msg', 'Password Lama tidak sesuai');
            return redirect()->to(base_url('Pegawai/profil/' . $id));
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

        return view('Pegawai/Profil/Ubah_profil', $data);
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

            $nama_foto = 'pegawaiFOTO' . $this->request->getPost('username') . '.' . $foto->guessExtension();
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
        session()->setFlashdata('msg', 'Profil Pegawai  berhasil Diubah');
        return redirect()->to(base_url('Pegawai/profil/' . $id));
    }

    public function register()
    {
        return view('auth/register');
    }
    public function user()
    {
        return view('user/index');
    }

    // Permintaan Barang
    public function permintaan()
    {
        $model = new PermintaanModel();
        // $data['pengaduan'] = $query;
        $this->builder = $this->db->table('permintaan_barang');
        $this->builder->select('*');
        $this->builder->where('id_user', user()->id);
        $this->query = $this->builder->get();
        $data['permintaan'] = $this->query->getResultArray();
        // dd(  $data['permintaan']);
        $data['title'] = 'Permintaan Barang';

        return view('Pegawai/Permintaan_barang/Index', $data);
    }

    public function list_permintaan($id)
    {
        $data['detail'] = $this->PermintaanModel->getPermintaan($id);
        $data['permintaan'] = $this->detailPermintaanModel
            ->select('detail_permintaan_barang.*, master_barang.nama_brg, satuan.nama_satuan,permintaan_barang.tanggal_permintaan, master_barang.merk,detail_master.tipe_barang')
            ->join('barang', 'barang.kode_barang = detail_permintaan_barang.kode_barang')
            ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
            ->join('permintaan_barang', 'permintaan_barang.permintaan_barang_id = detail_permintaan_barang.id_permintaan_barang')
            ->where('id_permintaan_barang', $id)->findAll();
        // dd(  $data['permintaan']);

        $data['title'] = 'Permintaan Barang';
        return view('Pegawai/Permintaan_barang/list_permintaan', $data);
    }

    // public function tambah_permintaan()
    // {
    //     $data = [
    //         'validation' => $this->validation,
    //         'title' => 'Tambah Permintaan',
    //         'barangList' => $this->BarangModel->findAll(), // Ambil daftar barang
    //     ];

    //     return view('Pegawai/Permintaan_barang/Tambah_permintaan', $data);
    // }

    // public function simpanPermin()
    // {
    //     // Validasi form
    //     if (!$this->validate([
    //         'kode_barang' => 'required',
    //         'nama_barang' => 'required',
    //         'jumlah' => 'required',
    //         'perihal' => [
    //                 'rules' => 'required|min_length[10]',
    //                 'errors' => [
    //                     'required' => 'Isi Permintaan wajib diisi.',
    //                     'min_length' => 'Minimal 10 karakter.',

    //                 ],
    //             ],
    //         'detail' => 'required',
    //         // Tambahkan aturan validasi lainnya sesuai kebutuhan
    //     ])) {
    //         $validation = \Config\Services::validation();

    //         // Dapatkan pesan kesalahan untuk setiap aturan validasi
    //         $errorKodeBarang = $validation->getError('kode_barang');
    //         $errorNamaBarang = $validation->getError('nama_barang');
    //         $errorJumlah = $validation->getError('jumlah');
    //         $errorPerihal = $validation->getError('perihal');
    //         $errorDetail = $validation->getError('detail');
    //         // Dapatkan pesan untuk validasi lainnya sesuai kebutuhan

    //         return redirect()
    //             ->to('/Pegawai/tambah_permintaan')
    //             ->withInput()
    //             ->with('errorKodeBarang', $errorKodeBarang)
    //             ->with('errorNamaBarang', $errorNamaBarang)
    //             ->with('errorJumlah', $errorJumlah)
    //             ->with('errorPerihal', $errorPerihal)
    //             ->with('errorDetail', $errorDetail);
    //         // Tambahkan variabel untuk pesan kesalahan validasi lainnya sesuai kebutuhan
    //     }


    //     // Retrieve data barang based on selected kode_barang
    //     $barang = $this->BarangModel->find($this->request->getPost('kode_barang'));

    //     if (!$barang) {
    //         // Tambahkan pesan kesalahan
    //         session()->setFlashdata('pesanGagal', 'Barang tidak ditemukan. Silakan pilih barang yang valid.');

    //         // Redirect ke halaman sebelumnya
    //         return redirect()->to('/Pegawai/tambah_permintaan')->withInput();
    //     }


    //     // Prepare data for saving
    //     $dataPermintaan = [
    //         'id_user' => user()->id,
    //         'kode_barang' => $this->request->getPost('kode_barang'),
    //         'nama_barang' => $barang['nama_barang'], // Menambahkan data nama_barang
    //         'jumlah' => $this->request->getPost('jumlah'),
    //         'perihal' => $this->request->getPost('perihal'),
    //         'detail' => $this->request->getPost('detail'),
    //         'nama_pengaju' => user()->username,
    //         'tanggal_pengajuan' => date("Y/m/d h:i:s"),
    //         'status' => 'belum diproses',
    //     ];

    //     // Save data to the database
    //     $this->PermintaanModel->save($dataPermintaan);

    //     // Flashdata pesan disimpan
    //     session()->setFlashdata('pesanBerhasil', 'Data Permintaan Berhasil Ditambahkan');

    //     return redirect()->to('/Pegawai/permintaan');
    // }
    public function tambah_permintaan()
    {
        $data = [
            'validation' => $this->validation,
            'title' => 'Tambah Permintaan',
            'barangList' => $this->BarangModel
                ->select('barang.*,master_barang.nama_brg, satuan.nama_satuan, master_barang.merk,detail_master.detail_master_id,detail_master.tipe_barang')
                ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
                ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
                ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
                ->findAll(),
            'selectedBarang' => null,
        ];

        $kode_barang = $this->request->getPost('kode_barang');
        if ($kode_barang) {
            $selectedBarang = $this->BarangModel->find($kode_barang);
            if ($selectedBarang) {
                $data['selectedBarang'] = $selectedBarang;
            }
        }

        return view('Pegawai/Permintaan_barang/Tambah_permintaan', $data);
    }

    public function simpanPermintaan()
    {

        $data = $this->request->getPost();
        // dd($data);
        // kode_permintaan =
        $kode_permintaan = 'PR-' . date('Ymdhis') . rand(100, 999);

        $permintaan = [
            'id_user' => user()->id,
            'permintaan_barang_id' => $kode_permintaan,
            'tanggal_permintaan' => date('Y-m-d'),
        ];
        $this->PermintaanModel->insert($permintaan);

        for ($i = 0; $i < count($data['kode_barang']); $i++) {
            $dataPermintaan = [
                
                'kode_barang' => $data['kode_barang'][$i],
                'jumlah' => $data['jumlah'][$i],
                'perihal' => $data['perihal'][$i],
                'detail' => $data['detail'][$i],
                'nama_pengaju' => user()->username,
                'tanggal_pengajuan' => date("Y/m/d h:i:s"),
                'status' => 'belum diproses',
                'id_permintaan_barang' => $kode_permintaan,
            ];
            // dd($dataPermintaan);
            $this->detailPermintaanModel->save($dataPermintaan);
        }

        session()->setFlashdata('msg', 'Permintaan berhasil diajukan, silahkan menunggu untuk proses approval.');
        return redirect()->to('Pegawai/permintaan/');
    }
    public function ubah($id)
    {

        session();
        $barangList = $this->BarangModel->getBarang();

        $data = [
            'title' => "BPS Ubah Data Permintaan",
            'validation' => \Config\Services::validation(),
            'barangList' => $barangList,
            'permintaan' => $this->detailPermintaanModel->getDetailPermintaan($id),
        ];



        return view('Pegawai/Permintaan_barang/Edit_permintaan', $data);
    }

    public function updatePermin($id)
    {
        $dataPermintaan = [
            'kode_barang' => $this->request->getPost('kode_barang'),
            'jumlah' => $this->request->getPost('jumlah'),
            'perihal' => $this->request->getPost('perihal'),
            'detail' => $this->request->getPost('detail'),
        ];
        // dd($dataPermintaan);

        $this->detailPermintaanModel->update($id, $dataPermintaan);
        $id_permintaan = $this->request->getPost('id_permintaan_barang');
        session()->setFlashdata('msg', 'Permintaan berhasil diperbarui.');
        return redirect()->to('/Pegawai/list_permintaan/' . $id_permintaan);
    }

    public function delete_permintaan($id)
    {
        $this->PermintaanModel->delete($id);
        session()->setFlashdata('msg', 'Permintaan berhasil dihapus.');
        return redirect()->to('/Pegawai/permintaan');
    }
    // public function ubah($id)
    // {
    //     session();
    //     $validation = \Config\Services::validation();

    //     // $permintaan = $this->PermintaanModel->find($id);
    //     $barangList = $this->BarangModel->findAll();
    //     $data = [
    //         'validation' => $validation,  // Corrected variable name here
    //         'title' => 'Edit Permintaan',
    //         'permintaan' => $this->PermintaanModel->getPermintaan($id),
    //         'barangList' => $barangList,
    //     ];


    //     return view('Pegawai/Permintaan_barang/Edit_permintaan', $data);

    // }
    // public function updatePermin($id)
    // {
    //     // Validasi form
    //     if (!$this->validate([
    //         'jumlah' => 'required',
    //         'perihal' => [
    //             'rules' => 'required|max_length[25]',
    //             'errors' => [
    //                 'required' => 'Perihal wajib di isi',
    //                 'max_length' => 'Minimal 25 karakter.'
    //             ],
    //         ],
    //         'detail' => 'required',
    //         'kode_barang' => 'required',
    //         // Tambahkan validasi lain sesuai kebutuhan
    //     ])) {
    //         $validation = \Config\Services::validation();
    //         return redirect()->to("/Pegawai/ubah/$id")->withInput()->with('validation', $validation);
    //     }

    //     // Ambil data barang berdasarkan kode_barang yang dipilih
    //     $barang = $this->BarangModel->find($this->request->getPost('kode_barang'));

    //     if (!$barang) {
    //         // Tangani jika barang tidak ditemukan, mungkin redirect dengan pesan kesalahan
    //         return redirect()->to("/Pegawai/ubah/$id")->with('error', 'Barang not found.');
    //     }

    //     // Update data permintaan
    //     $dataPermintaan = [
    //         'kode_barang' => $this->request->getPost('kode_barang'),
    //         'nama_barang' => $barang['nama_barang'], // Menambahkan data nama_barang
    //         'jumlah' => $this->request->getPost('jumlah'),
    //         'perihal' => $this->request->getPost('perihal'),
    //         'detail' => $this->request->getPost('detail'),
    //     ];

    //     // Update data ke database
    //     $this->PermintaanModel->update($id, $dataPermintaan);

    //     // Flashdata pesan berhasil diupdate
    //     session()->setFlashdata('pesanBerhasil', 'Data Permintaan Berhasil Diupdate');

    //     return redirect()->to('/Pegawai/permintaan');
    // }
    // public function updatePermin($id)
    // {

    //     // Validasi form
    //     if (!$this->validate([
    //         'jumlah' => 'required|numeric',
    //         'perihal' => [
    //             'rules' => 'required|max_length[20]',
    //             'errors' => [
    //                 'required' => 'Perihal wajib di isi',
    //                 'max_length' => 'Maksimal 20 karakter.'
    //             ],
    //         ],
    //         'detail' => 'required',
    //         'kode_barang' => 'required',
    //         // Tambahkan validasi lain sesuai kebutuhan
    //     ])) {
    //         $validation = \Config\Services::validation();

    //         // Dapatkan pesan kesalahan untuk setiap aturan validasi
    //         $errorJumlah = $validation->getError('jumlah');
    //         $errorPerihal = $validation->getError('perihal');
    //         $errorDetail = $validation->getError('detail');

    //         return redirect()
    //         ->to("/Pegawai/ubah/$id")
    //         ->withInput()
    //         ->with('errorJumlah', $errorJumlah)
    //         ->with('errorPerihal', $errorPerihal)
    //         ->with('errorDetail', $errorDetail)
    //         ->with('validation', $validation);

    //         // Tambahkan variabel untuk pesan kesalahan validasi lainnya sesuai kebutuhan
    //     }

    //     // Ambil data barang berdasarkan kode_barang yang dipilih
    //     $barang = $this->BarangModel->find($this->request->getPost('kode_barang'));

    //     if (!$barang) {
    //         // Tangani jika barang tidak ditemukan, mungkin redirect dengan pesan kesalahan
    //         return redirect()->to("/Pegawai/ubah/$id")->with('error', 'Barang not found.');
    //     }

    //     // Update data permintaan
    //     $dataPermintaan = [
    //         'kode_barang' => $this->request->getPost('kode_barang'),
    //         'nama_barang' => $barang['nama_barang'], // Menambahkan data nama_barang
    //         'jumlah' => $this->request->getPost('jumlah'),
    //         'perihal' => $this->request->getPost('perihal'),
    //         'detail' => $this->request->getPost('detail'),
    //     ];

    //     // Update data ke database
    //     $this->PermintaanModel->update($id, $dataPermintaan);

    //     // Flashdata pesan berhasil diupdate
    //     session()->setFlashdata('pesanBerhasil', 'Data Permintaan Berhasil Diupdate');

    //     return redirect()->to('/Pegawai/permintaan');
    // }


    public function detailpermin($id)
    {
        $barangList = $this->BarangModel->findAll();
        $data = $this->detailPermintaanModel->getDetailPermintaan($id);

        $d = $this->db->table('balasan_permintaan');
        $d->select('*');
        $d->where('id_permintaan_barang', $id);
        $balasan = $d->get()->getRow();

        // dd($query1);
        $ex = [

            'detail' => $data,
            'title' => 'Detail permintaan',
            'balasan' => $balasan,
            'barangList' => $barangList,

        ];
        // dd($ex);
        return view('Pegawai/Permintaan_barang/Detail_permintaan', $ex);
    }

    public function delete($id)
    {
        $data = [
            'validation' => \Config\Services::validation(),
            'permintaan' => $this->PermintaanModel->getPermintaan($id),
        ];

        $this->detailPermintaanModel->delete($id);
        session()->setFlashdata('pesanBerhasil', 'Data Permintaan Barang yang dipilih Berhasil Dihapus');

        // Redirect ke halaman index
        return redirect()->to('/Pegawai/permintaan');
    }

    public function print() // all data
    {
        $data = [
            'permintaan_barang' => $this->PermintaanModel->getAll(),
            'title' => 'Cetak Data',
        ];

        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);

        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml(view('Pegawai/Permintaan_barang/Print', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ini_set('max_execution_time', 0);
        $dompdf->stream('Data.pdf', array("Attachment" => false));
    }
    public function ekspor($id) //detail permintaan
    {
        // $aduan = $this->pengaduan->where(['id' => $id])->first();
        // $id = $id;
        // $data['detail']   = $aduan;
        $data['title'] = 'cetak';
        $data['detail'] = $this->detailPermintaanModel->where(['id' => $id])->first();

        //Cetak dengan dompdf
        $dompdf = new \Dompdf\Dompdf();
        ini_set('max_execution_time', 0);
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);

        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml(view('pegawai/permintaan_barang/cetakid', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Detail Permintaan.pdf', array("Attachment" => false));
    }

    // akhir permintaan

    // Inventaris
    public function inventaris()
    {
        // Ambil pesan modal dari flashdata
        $modal_message = session()->getFlashdata('modal_message');

        // Kirim pesan modal ke tampilan
        $data['modal_message'] = $modal_message;
        $this->builder = $this->db->table('inventaris');
        $this->builder->select('inventaris.*, master_barang.nama_brg,satuan.nama_satuan, master_barang.merk, detail_master.tipe_barang');
        $this->builder->join('detail_master', 'detail_master.detail_master_id = inventaris.id_master_barang');
        $this->builder->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang');
        $this->builder->join('satuan', 'satuan.satuan_id= inventaris.id_satuan');

        $this->query = $this->builder->get();
        $data['inventaris'] = $this->query->getResultArray();
        // dd(  $data['inventaris']);
        $data['title'] = 'BPS - Barang Inventaris';
        return view('Pegawai/Inventaris/Index', $data);
    }
    public function detail_inv($id)
    {
        $data['title'] = 'Detail'; // Pindahkan ini ke atas agar tidak terjadi override
        $this->builder = $this->db->table('inventaris'); // Gunakan $this->builder untuk mengakses builder

        $this->builder->select('inventaris.*, master_barang.nama_brg,satuan.nama_satuan, master_barang.merk,detail_master.tipe_barang');
        $this->builder->join('detail_master', 'detail_master.detail_master_id = inventaris.id_master_barang');
        $this->builder->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang');
        $this->builder->join('satuan', 'satuan.satuan_id= inventaris.id_satuan');
        $this->builder->where('kode_barang', $id);
        $query = $this->builder->get();
        $data['inventaris'] = $query->getRow();

        if (empty($data['inventaris'])) {
            return redirect()->to('/Pegawai/inventaris');
        }

        return view('Pegawai/Inventaris/Detail_inv', $data);
    }

    // ATK
    public function ATK()
    {
        $data = [
            'title' => 'BPS - Barang ATK',
            'barangs' => $this->BarangModel
                ->select('barang.*, master_barang.nama_brg, satuan.nama_satuan, master_barang.merk')
                ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
                ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
                ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
                ->findAll(),
        ];

        return view('Pegawai/ATK/Index', $data);
    }
    //Akhir ATK

    //Pengadaan Barang
    public function pengadaan()
    {

        $this->builder = $this->db->table('pengadaan_barang');
        $this->builder->select('*');
        $this->builder->where('id_user', user()->id);
        $this->query = $this->builder->get();
        $data['pengadaan'] = $this->query->getResultArray();
        // dd(  $data['inventaris']);
        $data['title'] = 'Pengadaan Barang';

        return view('Pegawai/Pengadaan/Index', $data);
    }

    public function tambah_pengadaan()
    {
        $data = [
            'validation' => $this->validation,
            'title' => 'Tambah Pengadaan Barang',

        ];
        return view('Pegawai/Pengadaan/Tambah_pengadaan', $data);
    }
    public function simpanPengadaan()
    {
        // get data post add data post
        $data = $this->request->getPost();
        // dd($data);
        // post to pengadaan
        $id_pengadaan = 'PG-' . date('Ymdhis') . rand(100, 999);
        $this->PengadaanModel->save([
            'pengadaan_barang_id' => $id_pengadaan,
             'id_user' => user()->id,
            'tanggal_pengadaan' => date("Y/m/d"),
            'tahun_periode' => $data['tahun_periode'],

        ]);
        // get id_pengadaan
        for ($i = 0; $i < count($data['nama_barang']); $i++) {
            $this->detailPengadaanModel->save([
                'id_pengadaan_barang' => $id_pengadaan,
                'nama_barang' => $data['nama_barang'][$i],
                'jumlah' => $data['jumlah'][$i],
                'spesifikasi' => $data['spesifikasi'][$i],
                'alasan_pengadaan' => $data['alasan_pengadaan'][$i],
                'nama_pengaju' => user()->username,
                'tgl_pengajuan' => date("Y/m/d h:i:s"),
                'status' => 'belum diproses',
            ]);
            // dd($data);
        }

        // Flashdata pesan disimpan
        session()->setFlashdata(
            'pesanBerhasil',
            'Data Pengadaan Berhasil Ditambahkan'
        );
        return redirect()->to('/Pegawai/pengadaan');

        // Flashdata pesan disimpan
        session()->setFlashdata(
            'pesanBerhasil',
            'Data Pengadaan Berhasil Ditambahkan'
        );
        return redirect()->to('/Pegawai/pengadaan');
    }



    public function editPengadaan($id)
    {
        $validation = \Config\Services::validation();

        $data['pengadaan'] = $this->detailPengadaanModel->getDetailPengadaan($id);
        $data['validation'] = $validation; // Pass the validation service to the view
        $data['title'] = 'Ubah Pengadaan'; // Pass the validation service to the view

        // Cek apakah pengadaan dengan id tersebut ditemukan
        if (!$data['pengadaan']) {
            // Redirect atau tampilkan pesan error jika tidak ditemukan
            return redirect()->to('/Pegawai/pengadaan')->with('pesanError', 'Pengadaan tidak ditemukan');
        }

        // Tampilkan formulir edit dengan data pengadaan
        return view('Pegawai/Pengadaan/Edit_pengadaan', $data);
    }

    public function updatePengadaan($id)
    {
        // Validasi input
        if (!$this->validate([
            'alasan_pengadaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'alasan_pengadaan wajib di isi',
                ],
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to("/Pegawai/editPengadaan/$id")->withInput()->with('validation', $validation);
        }

        // Dapatkan data pengadaan dari database
        $pengadaan = $this->detailPengadaanModel->getDetailPengadaan($id);

        // Cek apakah pengadaan dengan id tersebut ditemukan
        if (!$pengadaan) {
            // Redirect atau tampilkan pesan error jika tidak ditemukan
            return redirect()->to('/Pegawai/pengadaan')->with('pesanError', 'Pengadaan tidak ditemukan');
        }

        // Persiapkan data untuk disimpan
        $dataPengadaan = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'jumlah' => $this->request->getPost('jumlah'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'alasan_pengadaan' => $this->request->getPost('alasan_pengadaan'),
            'nama_pengaju' => user()->username,
        ];

        // Update data ke database
        $this->detailPengadaanModel->update($id, $dataPengadaan);

        // Flashdata pesan berhasil diupdate
        session()->setFlashdata('pesanBerhasil', 'Data Pengadaan Berhasil Diupdate');
        return redirect()->to('/Pegawai/detailPengadaan/' . $this->request->getPost('id_pengadaan_barang'));
    }

    public function detailPengadaanBarang($id)
    {

        $data = $this->detailPengadaanModel->getDetailPengadaan($id);

        $d = $this->db->table('balasan_pengadaan');
        $d->select('*');
        $d->where('id_pengadaan', $id);
        $balasan = $d->get()->getRow();

        // dd($query1);
        $ex = [

            'detail' => $data,
            'title' => 'Detail Pengadaan',
            'balasan' => $balasan,
            'validation' => \Config\Services::validation(),

        ];

        return view('Pegawai/Pengadaan/detail', $ex);
    }

    public function detailPengadaan($id)
    {

        $dataPengadaan = $this->PengadaanModel->getPengadaan($id);
        $detail_pengadaaan = $this->detailPengadaanModel->where('id_pengadaan_barang', $id)->findAll();

        $ex = [

            'title' => 'Detail Pengadaan Barang',
            'detail' => $dataPengadaan,
            'detail_pengadaaan' => $detail_pengadaaan,

        ];

        return view('Pegawai/Pengadaan/Detail_pengadaan', $ex);
    }
    public function deletePengadaan($id)
    {
        // dd($id);
        $this->PengadaanModel->hapusPengadaan($id);
        session()->setFlashdata('pesanBerhasil', 'Data Berhasil Dihapus');

        // Redirect ke halaman index
        return redirect()->to('/Pegawai/pengadaan');
    }

    public function printPB() // all data
    {
        $data = [
            'pengadaan' => $this->PengadaanModel->getAll(),
            'title' => 'Cetak Data',
        ];

        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);

        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml(view('user/pengadaan/print', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ini_set('max_execution_time', 0);
        $dompdf->stream('Data.pdf', array("Attachment" => false));
    }
    public function eksporPB($id) //detail permintaan
    {
        // $aduan = $this->pengaduan->where(['id' => $id])->first();
        // $id = $id;
        // $data['detail']   = $aduan;
        $data['title'] = 'cetak';
        $data['detail'] = $this->PengadaanModel->where(['id' => $id])->first();

        //Cetak dengan dompdf
        $dompdf = new \Dompdf\Dompdf();
        ini_set('max_execution_time', 0);
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);

        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml(view('user/pengadaan/cetakid', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Detail Pengadaan.pdf', array("Attachment" => false));
    }
    
    public function Scan()
    {
        $data = [
            'title' => 'Scan QR Barang',
        ];
        return view('Pegawai/Scan/index', $data);
    }
    //Akhir Pengadaan
    // //Pengadaan Barang
    // public function pengadaan()
    // {
    //     // $model = new PermintaanModel();
    //     // // $data['pengaduan'] = $query;
    //     // $this->builder = $this->db->table('permintaan_barang');
    //     // $this->builder->select('*');
    //     // $this->builder->where('id_user', user()->id);
    //     // $this->query = $this->builder->get();
    //     // $data['permintaan'] = $this->query->getResultArray();
    //     // // dd(  $data['permintaan']);
    //     // $data['permintaan'] = $model->getPermintaanWithBarang();
    //     // $data['title'] = 'Permintaan Barang';
    //     $this->builder = $this->db->table('pengadaan_barang');
    //     $this->builder->select('*');
    //     $this->builder->where('id_user', user()->id);
    //     $this->query = $this->builder->get();
    //     $data['pengadaan'] = $this->query->getResultArray();
    //     // dd(  $data['inventaris']);
    //     $data['title'] = 'Pengadaan Barang';

    //     return view('user/pengadaan/index', $data);
    // }

    // public function tambah_pengadaan()
    // {
    //     $data = [
    //         'validation' => $this->validation,
    //         'title' => 'Tambah Pengadaan Barang',

    //     ];
    //     return view('user/pengadaan/tambah_pengadaan', $data);
    // }

    // public function simpanPengadaan()
    // {
    //     if (!$this->validate([
    //         'alasan_pengadaan' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Perihal wajib di isi',
    //             ],
    //         ],

    //     ])) {
    //         $validation = \Config\Services::validation();
    //         return redirect()->to('/user/tambah_pengadaan')->withInput()->with('validation', $validation);
    //     }

    //     // Determine the value for 'nama_pengaju'

    //     // Prepare data for saving
    //     $dataPengadaan = [
    //         'id_user' => user()->id,
    //         'nama_barang' => $this->request->getPost('nama_barang'),
    //         'jumlah' => $this->request->getPost('jumlah'),
    //         'spesifikasi' => $this->request->getPost('spesifikasi'),
    //         'tahun_periode' => $this->request->getPost('tahun_periode'),
    //         'alasan_pengadaan' => $this->request->getPost('alasan_pengadaan'),
    //         'nama_pengaju' => user()->username,
    //         'tgl_pengajuan' => date("Y/m/d h:i:s"),
    //         'status' => 'belum diproses',
    //     ];

    //     // Save data to the database
    //     $this->PengadaanModel->save($dataPengadaan);

    //     // Flashdata pesan disimpan
    //     session()->setFlashdata('pesanBerhasil', 'Data Pengadaan Berhasil Ditambahkan');
    //     return redirect()->to('/user/pengadaan');
    // }
    // public function editPengadaan($id)
    // {
    //     $validation = \Config\Services::validation();

    //     $data['pengadaan'] = $this->PengadaanModel->find($id);
    //     $data['validation'] = $validation; // Pass the validation service to the view
    //     $data['title'] = 'Ubah Pengadaan'; // Pass the validation service to the view

    //     // Cek apakah pengadaan dengan id tersebut ditemukan
    //     if (!$data['pengadaan']) {
    //         // Redirect atau tampilkan pesan error jika tidak ditemukan
    //         return redirect()->to('/user/pengadaan')->with('pesanError', 'Pengadaan tidak ditemukan');
    //     }

    //     // Tampilkan formulir edit dengan data pengadaan
    //     return view('user/pengadaan/edit_pengadaan', $data);
    // }

    // public function updatePengadaan($id)
    // {
    //     // Validasi input
    //     if (!$this->validate([
    //         'alasan_pengadaan' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Perihal wajib di isi',
    //             ],
    //         ],

    //     ])) {
    //         $validation = \Config\Services::validation();
    //         return redirect()->to("/user/editPengadaan/$id")->withInput()->with('validation', $validation);
    //     }

    //     // Dapatkan data pengadaan dari database
    //     $pengadaan = $this->PengadaanModel->find($id);

    //     // Cek apakah pengadaan dengan id tersebut ditemukan
    //     if (!$pengadaan) {
    //         // Redirect atau tampilkan pesan error jika tidak ditemukan
    //         return redirect()->to('/user/pengadaan')->with('pesanError', 'Pengadaan tidak ditemukan');
    //     }

    //     // Tentukan nilai untuk 'nama_pengaju'
    //     $nama_pengaju = $this->request->getPost('nama_pengaju') == 'anonym' ? 'anonym' : $this->request->getPost('nama_pengaju');

    //     // Persiapkan data untuk disimpan
    //     $dataPengadaan = [
    //         'nama_barang' => $this->request->getPost('nama_barang'),
    //         'jumlah' => $this->request->getPost('jumlah'),
    //         'spesifikasi' => $this->request->getPost('spesifikasi'),
    //         'tahun_periode' => $this->request->getPost('tahun_periode'),
    //         'alasan_pengadaan' => $this->request->getPost('alasan_pengadaan'),
    //         'nama_pengaju' => $nama_pengaju,
    //     ];

    //     // Update data ke database
    //     $this->PengadaanModel->update($id, $dataPengadaan);

    //     // Flashdata pesan berhasil diupdate
    //     session()->setFlashdata('pesanBerhasil', 'Data Pengadaan Berhasil Diupdate');
    //     return redirect()->to('/user/pengadaan');
    // }

    // public function detailPengadaan($id)
    // {

    //     $data = $this->db->table('pengadaan_barang');
    //     $data->select('*');
    //     $data->where('id', $id);
    //     $query = $data->get();

    //     $d = $this->db->table('balasan_pengadaan');
    //     $d->select('*');
    //     $d->where('id_pengadaan', $id);
    //     $balasan = $d->get()->getRow();

    //     // dd($query1);
    //     $ex = [

    //         'detail' => $query->getRow(),
    //         'title' => 'Detail Pengadaan Barang',
    //         'balasan' => $balasan,

    //     ];

    //     return view('user/pengadaan/detail_pengadaan', $ex);
    // }
    // public function deletePengadaan($id)
    // {
    //     $data = [
    //         'validation' => \Config\Services::validation(),
    //         'pengadaan' => $this->PengadaanModel->getpengadaan($id),
    //     ];

    //     $this->PengadaanModel->delete($id);
    //     session()->setFlashdata('pesanBerhasil', 'Data Berhasil Dihapus');

    //     // Redirect ke halaman index
    //     return redirect()->to('/user/pengadaan');
    // }

    // public function printPB() // all data
    // {
    //     $data = [
    //         'pengadaan' => $this->PengadaanModel->getAll(),
    //         'title' => 'Cetak Data',
    //     ];

    //     $dompdf = new \Dompdf\Dompdf();
    //     $options = new \Dompdf\Options();
    //     $options->setIsRemoteEnabled(true);

    //     $dompdf->setOptions($options);
    //     $dompdf->output();
    //     $dompdf->loadHtml(view('user/pengadaan/print', $data));
    //     $dompdf->setPaper('A4', 'portrait');
    //     $dompdf->render();
    //     ini_set('max_execution_time', 0);
    //     $dompdf->stream('Data.pdf', array("Attachment" => false));
    // }
    // public function eksporPB($id) //detail permintaan
    // {
    //     // $aduan = $this->pengaduan->where(['id' => $id])->first();
    //     // $id = $id;
    //     // $data['detail']   = $aduan;
    //     $data['title'] = 'cetak';
    //     $data['detail'] = $this->PengadaanModel->where(['id' => $id])->first();

    //     //Cetak dengan dompdf
    //     $dompdf = new \Dompdf\Dompdf();
    //     ini_set('max_execution_time', 0);
    //     $options = new \Dompdf\Options();
    //     $options->setIsRemoteEnabled(true);

    //     $dompdf->setOptions($options);
    //     $dompdf->output();
    //     $dompdf->loadHtml(view('user/pengadaan/cetakid', $data));
    //     $dompdf->setPaper('A4', 'portrait');
    //     $dompdf->render();
    //     $dompdf->stream('Detail Pengadaan.pdf', array("Attachment" => false));
    // }
    //Akhir Pengadaan
}
