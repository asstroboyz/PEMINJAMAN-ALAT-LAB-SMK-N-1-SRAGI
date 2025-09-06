<?php

namespace App\Controllers;

use App\Models\BalasanModel;
use App\Models\BalasanPengadaan;
use App\Models\PengadaanModel;
use App\Models\detailPengadaanModel;
use App\Models\profil;

class Petugas_pengadaan extends BaseController
{
    protected $db;
    protected $builder;
    protected $PengadaanModel;
    protected $validation;
    protected $session;
    protected $profil;
    protected $detailPengadaanModel;
    protected $BalasanPengadaan;
    public function __construct()
    {
        $this->detailPengadaanModel = new detailPengadaanModel();
        $this->PengadaanModel = new PengadaanModel();
        $this->profil = new profil();
        $this->BalasanPengadaan = new BalasanPengadaan();
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $userlogin = user()->id;

        // Menghitung jumlah inventaris

        // Menghitung total untuk masing-masing status pengadaan_barang
        $queryPengadaan = $this->db->table('detail_pengadaan_barang')->get()->getResult();
        $queryProsesPengadaan = $this->db->table('detail_pengadaan_barang')->where('status', 'diproses')->get()->getResult();
        $querySelesaiPengadaan = $this->db->table('detail_pengadaan_barang')->where('status', 'selesai')->get()->getResult();


        $semua_pengadaan = count($queryPengadaan);
        $proses_pengadaan = count($queryProsesPengadaan);
        $selesai_pengadaan = count($querySelesaiPengadaan);



        $data = [
            'title' => 'BPS - Home',

            'semua_pengadaan' => $semua_pengadaan,
            'proses_pengadaan' => $proses_pengadaan,
            'selesai_pengadaan' => $selesai_pengadaan,

        ];
        return view('Petugas_pengadaan/Profil/Home', $data);
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
            // Memeriksa ID role, anggap saja ID role admin adalah 1, dan ID role kepala_bps adalah 4 (sesuaikan dengan struktur tabel Anda)
            $adminRoleId = 1;
            $petugasPengadaan = 2;

            // Menentukan status role berdasarkan ID role
            if ($roleData->group_id == $adminRoleId) {
                $role_echo = 'admin';
            } elseif ($roleData->group_id == $petugasPengadaan) {
                $role_echo = 'Petugas Pengadaan';
            } else {
                $role_echo = 'user';
            }
        } else {
            // Jika data role tidak ditemukan, mengatur nilai default sebagai 'user'
            $role_echo = 'user';
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
            'title' => 'Profil - BPS',
            'role' => $role_echo,

        ];

        return view('Petugas_Pengadaan/Profil/Index', $data);
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


            $nama_foto = 'PetugasFOTO' . $this->request->getPost('username') . '.' . $foto->guessExtension();
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
        session()->setFlashdata('msg', 'Profil Petugas  berhasil Diubah');
        return redirect()->to(base_url('Petugas_pengadaan/profil/' . $id));
    }
    public function updatePassword($id)
    {
        $passwordLama = $this->request->getPost('passwordLama');
        $passwordbaru = $this->request->getPost('passwordBaru');
        $konfirm = $this->request->getPost('konfirm');

        if ($passwordbaru != $konfirm) {
            session()->setFlashdata('error-msg', 'Password Baru tidak sesuai');
            return redirect()->to(base_url('Petugas_pengadaan/profil/' . $id));
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
            return redirect()->to('/Petugas_pengadaan/profil/' . $id);
        } else {
            session()->setFlashdata('error-msg', 'Password Lama tidak sesuai');
            return redirect()->to(base_url('Petugas_pengadaan/profil/' . $id));
        }
    }
    public function pengadaan()
    {
        $this->builder = $this->db->table('pengadaan_barang');
        $this->builder->select('*');
        $this->query = $this->builder->get();
        $data['pengadaan'] = $this->query->getResultArray();
        // dd(  $data['inventaris']);
        $data['title'] = 'Daftar pengadaan Barang';
        return view('Petugas_pengadaan/Pengadaan/Index', $data);
    }
    public function list_pengadaan($id)
    {
        $dataPengadaan = $this->PengadaanModel->getPengadaan($id);
        $detail_pengadaaan = $this->detailPengadaanModel->where('id_pengadaan_barang', $id)->findAll();

        $ex = [

            'title' => 'Detail Pengadaan Barang',
            'detail' => $dataPengadaan,
            'detail_pengadaaan' => $detail_pengadaaan,

        ];
        return view('Petugas_pengadaan/Pengadaan/list_pengadaan', $ex);
    }
    public function Pengadaan_masuk()
    {
        $this->builder = $this->db->table('detail_pengadaan_barang');
        $this->builder->select('*');
        $this->builder->where('status', 'belum diproses');
        $this->query = $this->builder->get();
        $data = [
            'pengadaan' => $this->query->getResultArray(),
            'title' => 'Daftar Pengadaan Barang Masuk',
        ];
        return view('Petugas_pengadaan/Pengadaan/Indexx', $data);
    }
    public function Pengadaan_proses()
    {
        $this->builder = $this->db->table('detail_pengadaan_barang');
        $this->builder->select('*');
        $this->builder->where('status', 'diproses');
        $this->query = $this->builder->get();
        $data = [
            'pengadaan' => $this->query->getResultArray(),
            'title' => 'Daftar Pengadaan Barang Diproses',
        ];
        return view('Petugas_pengadaan/Pengadaan/Indexx', $data);
    }
    public function Pengadaan_selesai()
    {
        $this->builder = $this->db->table('detail_pengadaan_barang');
        $this->builder->select('*');
        $this->builder->where('status', 'selesai');
        $this->query = $this->builder->get();
        $data = [
            'pengadaan' => $this->query->getResultArray(),
            'title' => 'Daftar Pengadaan Barang Selesai',
        ];
        return view('Petugas_pengadaan/Pengadaan/Indexx', $data);
    }
    public function prosesPengadaan($id)
    {
        $date =
            $this->detailPengadaanModel->update($id, [
                'tgl_proses' => date("Y-m-d h:i:s"),
                'status' => 'diproses',

            ]);
        session()->setFlashdata('msg', 'Status permintaan berhasil Diubah');
        return redirect()->to('Petugas_pengadaan/detailPengadaan/' . $id);
    }
    public function accPengadaan($id)
    {
        // $this->PengadaanModel->update($id, [
        //     'tgl_selesai' => date("Y-m-d h:i:s"),
        //     'status' => 'selesai',
        //     'status_akhir' => 'diterima',

        // ]);
        // session()->setFlashdata('msg', 'Status permintaan berhasil Diubah');
        // return redirect()->to('Petugas_pengadaan/detailPengadaan/' . $id);
        // Mengambil nilai jumlah_disetujui dari input form
        // $jumlahDisetujui = $this->request->getPost('jumlah_disetujui');

        // Mendapatkan data pengadaan

        // Memastikan jumlah_disetujui tidak lebih besar dari jumlah dan tidak boleh 0
        // $jumlahDisetujui = max(1, min($jumlahDisetujui, $pengadaanData['jumlah']));
        // $catatan = $this->request->getPost('catatan');


        // Melakukan pembaruan pada database
        $this->detailPengadaanModel->update($id, [
            'tgl_selesai' => date("Y-m-d h:i:s"),
            'status' => 'selesai',
            'catatan' => $this->request->getPost('catatan'),
            'status_akhir' => 'diterima',
            'jumlah_disetujui' => $this->request->getPost('jumlah_ditrima'),
        ]);

        // balasan
        $data = [
            'id_pengadaan' => $id,
            'kategori' => 'Pengajuan Barang Diterima',
            'balasan_pengadaan' => $this->request->getPost('catatan'),
        ];
        $this->BalasanPengadaan->save($data);

        // Menyimpan pesan flash untuk notifikasi
        session()->setFlashdata('msg', 'Status Pengadaan Barang berhasil Disetujui');

        // Redirect ke halaman detail
        return redirect()->to('Petugas_pengadaan/detailPengadaan/' . $id);
    }
    public function balasPengadaan($id)
    {
        $rules = [
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori  wajib diisi.',
                ],
            ],
            'balasan_pengadaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Balasan wajib diisi.',

                ],
            ],

        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return redirect()->to('/Petugas_pengadaan/detailPengadaan/' . $id)->withInput('validation', $validation);
        }
        $this->detailPengadaanModel->update($id, [
            'tgl_selesai' => date("Y-m-d h:i:s"),
            'status' => 'selesai',
            'status_akhir' => 'ditolak',

        ]);
        $data = [
            'id_pengadaan' => $id,
            'kategori' => $this->request->getPost('kategori'),
            'balasan_pengadaan' => $this->request->getPost('balasan_pengadaan'),

        ];
        $this->BalasanPengadaan->save($data);
        session()->setFlashdata('msg', 'Status Penolakan Pengadaan berhasil Dikirim');
        return redirect()->to('Petugas_pengadaan/detailPengadaan/' . $id);
    }
    public function detailPengadaan($id)
    {

        $data = $this->db->table('detail_pengadaan_barang');
        $data->select('*');
        $data->where('id', $id);
        $query = $data->get();

        $d = $this->db->table('balasan_pengadaan');
        $d->select('*');
        $d->where('id_pengadaan', $id);
        $balasan = $d->get()->getRow();

        // dd($query1);
        $ex = [

            'detail' => $query->getRow(),
            'title' => 'Detail Pengadaan',
            'balasan' => $balasan,
            'validation' => \Config\Services::validation(),

        ];

        return view('Petugas_pengadaan/Pengadaan/Detail_pengadaan', $ex);
    }

    public function lap_pengadaan()
    {
        $data = [
            // 'user'=> $query->getResult(),
            'title' => 'BPS - Laporan Pengadaan Barang',

        ];

        return view('Petugas_pengadaan/Laporan/Home_pengadaan', $data);
    }

    public function cetakDataPengadaan()
    {

        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        // Validasi tanggal
        if (empty($tanggalMulai) || empty($tanggalAkhir)) {
            return redirect()->to(base_url('Petugas_pengadaan'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
        }

        $dateMulai = strtotime($tanggalMulai);
        $dateAkhir = strtotime($tanggalAkhir);

        if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
            return redirect()->to(base_url('Petugas_pengadaan'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
        }

        $detailPengadaanModel = new detailPengadaanModel();
        $pengadaanModel = new PengadaanModel();
        $balasanModel = new BalasanPengadaan();
        $dataAll = [];
        $dataPengadaan = $pengadaanModel->where('tanggal_pengadaan >=', $tanggalMulai)->where('tanggal_pengadaan <=', $tanggalAkhir)->findAll();
        // dd($dataPengadaan);

        foreach ($dataPengadaan as $pengadaan) {
            $detailPengadaan = $detailPengadaanModel->where('id_pengadaan_barang', $pengadaan['pengadaan_barang_id'])->findAll();
            // $balasan = $balasanModel
            //     ->select('balasan_pengadaan.*, detail_pengadaan_barang.*')
            //     ->join('detail_pengadaan_barang', 'detail_pengadaan_barang.id = balasan_pengadaan.id_pengadaan')
            //     ->where('detail_pengadaan_barang.id_pengadaan_barang', $pengadaan['pengadaan_barang_id'])
            //     ->findAll();

            $dataAll[] = [
                'data_pengadaan' => $pengadaan,
                'balasan' => $detailPengadaan,
                // 'detail_pengadaan' => $detailPengadaan,
            ];
        }

        $data['pengadaan'] = $dataAll;
        // dd($data['pengadaan']);


        $userlogin = user()->username;

        // ...

        $data['userlogin'] = $userlogin;

        $data['tanggalMulai'] = $tanggalMulai; // Add this line
        $data['tanggalAkhir'] = $tanggalAkhir;



        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('Petugas_pengadaan/Laporan/Lap_pengadaan', $data);

        $mpdf->setAutoPageBreak(true);

        $options = [
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ],
        ];

        $mpdf->AddPageByArray(['orientation' => 'L'] + $options);


        $mpdf->WriteHtml($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Lap Pengadaan Barang.pdf', 'I');
    }

    public function cetakPengadaan($kode_pengadaan)
    {
        $pengadaanModel = new PengadaanModel();
        $data['pengadaan'] = $pengadaanModel
            ->select('*')
            ->where('pengadaan_barang_id', $kode_pengadaan)
            ->first();

        if (empty($data['pengadaan'])) {
            // Handle the case when no data is found for the given kode_pengadaan
            return redirect()->to(base_url('Admin'))->with('error', 'Data not found for kode_pengadaan: ' . $kode_pengadaan);
        }

        $detailPengadaan = new DetailPengadaanModel();
        $data['detail_pengadaan'] = $detailPengadaan
            ->select('detail_pengadaan_barang.*, pengadaan_barang.tahun_periode, pengadaan_barang.tanggal_pengadaan')
            ->join('pengadaan_barang', 'pengadaan_barang.pengadaan_barang_id = detail_pengadaan_barang.id_pengadaan_barang')
            ->where('id_pengadaan_barang', $kode_pengadaan)
            ->findAll();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('Petugas_pengadaan/Laporan/cetak_pengadaan', $data);

        $mpdf->setAutoPageBreak(true);

        $options = [
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ],
        ];

        $mpdf->AddPageByArray(['orientation' => 'L'] + $options);


        $mpdf->WriteHtml($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Laporan pengadaan.pdf', 'I');
    }
}
