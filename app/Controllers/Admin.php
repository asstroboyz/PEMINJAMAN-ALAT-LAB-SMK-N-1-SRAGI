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
use Myth\Auth\Entities\User;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;

/**
 * @property Home_model $home_model
 * @property Ciqrcode $ciqrcode
 * @property CI_Input $input
 */

class Admin extends BaseController
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
        $this->ciqrcode                = new \App\Libraries\Ciqrcode();
        $this->masterBarangModel       = new masterBarangModel();
        $this->KategoriBarangModel     = new KategoriBarangModel();
        $this->MerkBarangModel         = new MerkBarangModel();
        $this->MerkKategoriBarangModel = new MerkKategoriBarangModel();
    }

    public function index()
    {

        $data = [
            'title' => 'PEMINJAMAN ALAT - Home',
        ];
        // dd($data);
        return view('Admin/Home/Index', $data);
    }
    public function user_list()
    {
        $data['title'] = 'User List';
        // $users = new \Myth\Auth\Models\UserModel();
        // $data['users']  = $users->findAll();

        //join tabel memanggil fungsi
        $this->builder->select('users.id as userid, username, email, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get();

        $data['users'] = $query->getResult();
        return view('Admin/User_list', $data);
    }

    public function detail($id = 0)
    {
        $data['title'] = 'BPS - Detail Pengguna';

        $this->builder->select('users.id as userid, username, email, foto, name,created_at');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();

        $data['user'] = $query->getRow();

        if (empty($data['user'])) {
            return redirect()->to('/Admin');
        }

        return view('Admin/Detail', $data);
    }

    public function profil()
    {
        $data['title']            = 'User Profile ';
        $userlogin                = user()->username;
        $userid                   = user()->id;
        $role                     = $this->db->table('auth_groups_users')->where('user_id', $userid)->get()->getRow();
        $role == '1' ? $role_echo = 'Admin' : $role_echo = 'Pegawai'; // $data['title'] = 'User Profile ';
        $userlogin                = user()->username;
        $userid                   = user()->id;

        // Mengambil data role dari tabel auth_groups_users
        $roleData = $this->db->table('auth_groups_users')->where('user_id', $userid)->get()->getRow();

        // Memeriksa apakah data role ditemukan
        if ($roleData) {

            $adminRoleId      = 1;
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

        $data    = $this->db->table('permintaan_barang');
        $query1  = $data->where('id_user', $userid)->get()->getResult();
        $builder = $this->db->table('users');
        $builder->select('id,username,email,created_at,foto');
        $builder->where('username', $userlogin);
        $query = $builder->get();
        $semua = count($query1);
        $data  = [
            'semua' => $semua,
            'user'  => $query->getRow(),
            'title' => 'Profil - BPS',
            'role'  => $role_echo,

        ];

        return view('Admin/Home/Profil', $data);
    }

    public function simpanProfile($id)
    {
        $userlogin = user()->username;
        $builder   = $this->db->table('users');
        $builder->select('*');
        $query = $builder->where('username', $userlogin)->get()->getRowArray();

        $foto = $this->request->getFile('foto');
        if ($foto->getError() == 4) {
            $this->profil->update($id, [
                'email'    => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
            ]);
        } else {

            $nama_foto = 'AdminFOTO' . $this->request->getPost('username') . '.' . $foto->guessExtension();
            if (! (empty($query['foto']))) {
                unlink('uploads/profile/' . $query['foto']);
            }
            $foto->move('uploads/profile', $nama_foto);

            $this->profil->update($id, [
                'email'    => $this->request->getPost('email'),
                'username' => $this->request->getPost('username'),
                'foto'     => $nama_foto,
            ]);
        }
        session()->setFlashdata('msg', 'Profil Admin  berhasil Diubah');
        return redirect()->to(base_url('Admin/profil/' . $id));
    }
    public function updatePassword($id)
    {
        $passwordLama = $this->request->getPost('passwordLama');
        $passwordbaru = $this->request->getPost('passwordBaru');
        $konfirm      = $this->request->getPost('konfirm');

        if ($passwordbaru != $konfirm) {
            session()->setFlashdata('error-msg', 'Password Baru tidak sesuai');
            return redirect()->to(base_url('admin/profil/' . $id));
        }

        $builder = $this->db->table('users');
        $builder->where('id', user()->id);
        $query       = $builder->get()->getRow();
        $verify_pass = password_verify(base64_encode(hash('sha384', $passwordLama, true)), $query->password_hash);

        if ($verify_pass) {
            $users  = new UserModel();
            $entity = new \Myth\Auth\Entities\User();

            $entity->setPassword($passwordbaru);
            $hash = $entity->password_hash;
            $users->update($id, ['password_hash' => $hash]);
            session()->setFlashdata('msg', 'Password berhasil Diubah');
            return redirect()->to('/admin/profil/' . $id);
        } else {
            session()->setFlashdata('error-msg', 'Password Lama tidak sesuai');
            return redirect()->to(base_url('admin/profil/' . $id));
        }
    }

    // satuan
    public function satuan()
    {
        $data = [
            'title'  => 'Satuan Barang',
            'satuan' => $this->satuanModel->findAll(),
        ];
        return view('Admin/Satuan/Index', $data);
    }

    public function tambah_satuan()
    {
        $data = [
            'title'      => 'Tambah Satuan',
            'validation' => $this->validation,
        ];
        return view('Admin/Satuan/Tambah_satuan', $data);
    }
    public function simpanSatuan()
    {
        if (! $this->validate([

            'nama_satuan' => [
                'rules'  => 'required|is_unique[satuan.nama_satuan]',
                'errors' => [
                    'required'  => 'nama satuan harus diisi',
                    'is_unique' => 'nama satuan sudah ada',
                ],
            ],
        ])) {
            return redirect()->to('/admin/tambah_satuan')->withInput();
        }
        $data = [
            'nama_satuan' => $this->request->getPost('nama_satuan'),
        ];
        // dd($data);
        $this->satuanModel->insert($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin/satuan');
    }
    public function satuan_edit($id)
    {
        $data = [
            'title'      => 'Ubah Satuan',
            'validation' => $this->validation,
            'satuan'     => $this->satuanModel->find($id),
        ];
        return view('Admin/Satuan/Edit_satuan', $data);
    }
    public function updateSatuan()
    {
        $id   = $this->request->getPost('id');
        $data = [
            'nama_satuan' => $this->request->getPost('nama_satuan'),
        ];
        $this->satuanModel->update($id, $data);
        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/admin/satuan');
    }
    public function satuan_delete($id)
    {
        $this->satuanModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/admin/satuan');
    }
    // master barang
    public function master_barang()
    {
        $data['title'] = 'Master Barang';

        $data['master_brg'] = $this->masterBarangModel
            ->select('master_barang.*')
            ->orderBy('jenis_brg', 'ASC')
            ->findAll();

        return view('Admin/Master_barang/Index', $data);
    }

    public function masterBarang()
    {
        $data['title']      = 'Master Barang';
        $data['master_brg'] = $this->masterBarangModel
            ->orderBy('jenis_brg', 'ASC')
            ->getMasterBarang();

        // dd($data);
        return view('Admin/Master_barang/Index', $data);
    }

    public function addBarang()
    {
        $data = [
            'title'           => 'Tambah Barang',
            'validation'      => $this->validation,
            'satuan'          => $this->satuanModel->findAll(),
            'kategori_barang' => $this->KategoriBarangModel->findAll(),
        ];
        return view('Admin/Master_barang/Tambah_barang', $data);
    }
    public function getMerkByKategori($kategori_id)
    {
        $merk = $this->MerkKategoriBarangModel
            ->select('merk_barang.id, merk_barang.nama_merk')
            ->join('merk_barang', 'merk_kategori_barang.merk_id = merk_barang.id')
            ->where('merk_kategori_barang.kategori_id', $kategori_id)
            ->findAll();

        return $this->response->setJSON($merk);
    }

    public function saveBarang1()
    {
        if (! $this->validate([
            'nama_barang' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama Barang harus diisi'],
            ],
            'kategori_id' => [
                'rules'  => 'required|is_not_unique[kategori_barang.id]',
                'errors' => ['required' => 'Kategori harus diisi'],
            ],
            'merk_id'     => [
                'rules'  => 'required|is_not_unique[merk_barang.id]',
                'errors' => ['required' => 'Merk harus diisi'],
            ],
            'jenis_brg'   => [
                'rules'  => 'required|in_list[hrd,sfw,tools]',
                'errors' => ['required' => 'Jenis Barang harus diisi'],
            ],
            'id_satuan'   => [
                'rules'  => 'required|is_not_unique[satuan.satuan_id]',
                'errors' => ['required' => 'Satuan harus diisi'],
            ],
            // Tambah validasi lain kalau perlu
        ])) {
            return redirect()->to('/admin/addBarang')->withInput();
        }

        // Ambil input
        $nama_barang = $this->request->getPost('nama_barang');
        $kategori_id = $this->request->getPost('kategori_id');
        $merk_id     = $this->request->getPost('merk_id');
        $jenis_brg   = $this->request->getPost('jenis_brg');
        $spesifikasi = $this->request->getPost('spesifikasi');
        $id_satuan   = (int) $this->request->getPost('id_satuan');
        $is_active   = (int) ($this->request->getPost('is_active') ?? 1);

        // Generate kode unik
        $prefix   = strtoupper(substr(preg_replace('/\s+/', '', $nama_barang), 0, 3));
        $kode_brg = $prefix . '-' . date('Ymd') . '-' . rand(100, 999);

        // Data untuk master_barang (FK, bukan string!)
        $data = [
            'kode_brg'    => $kode_brg,
            'nama_brg'    => $nama_barang,
            'kategori_id' => $kategori_id,
            'merk_id'     => $merk_id,
            'jenis_brg'   => $jenis_brg,
            'spesifikasi' => $spesifikasi,
            'id_satuan'   => $id_satuan,
            'is_active'   => $is_active,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        // Insert ke master_barang
        $this->masterBarangModel->insert($data);

        // Insert ke pengecekan jika jenis_brg == 'hrd'
        if ($jenis_brg == 'hrd') {
            $dataPengecekan = [
                'id_inventaris'      => $kode_brg, // atau sesuaikan dengan inventaris kode
                'tanggal_pengecekan' => date('Y-m-d'),
                'ruangan_id_lama'    => null, // Atau isi ID ruangan lama kalau ada
                'keterangan'         => 'Barang HRD baru, pengecekan awal',
            ];
            $this->pengecekanModel->insert($dataPengecekan);
        }

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin/master_barang');
    }
    public function saveBarang()
    {
        if (! $this->validate([
            'nama_barang' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama Barang harus diisi'],
            ],
            'kategori_id' => [
                'rules'  => 'required|is_not_unique[kategori_barang.id]',
                'errors' => ['required' => 'Kategori harus diisi'],
            ],
            'jenis_brg'   => [
                'rules'  => 'required|in_list[hrd,sfw,tools]',
                'errors' => ['required' => 'Jenis Barang harus diisi'],
            ],
            'id_satuan'   => [
                'rules'  => 'required|is_not_unique[satuan.satuan_id]',
                'errors' => ['required' => 'Satuan harus diisi'],
            ],
            'foto'        => [
                'rules'  => 'is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
                'errors' => [
                    'is_image' => 'File harus gambar!',
                    'mime_in'  => 'File harus jpg/jpeg/png',
                    'max_size' => 'Maksimal 2MB',
                ],
            ],
        ])) {
            return redirect()->to('/admin/addBarang')->withInput();
        }

        // Ambil input
        $nama_barang = $this->request->getPost('nama_barang');
        $tipe_serie  = $this->request->getPost('tipe_serie');
        $kategori_id = $this->request->getPost('kategori_id');
        $merk_id     = $this->request->getPost('merk');
        $jenis_brg   = $this->request->getPost('jenis_brg');
        $spesifikasi = $this->request->getPost('spesifikasi');
        $id_satuan   = (int) $this->request->getPost('id_satuan');
        $is_active   = (int) ($this->request->getPost('is_active') ?? 1);

        // Foto
        $foto         = $this->request->getFile('foto');
        $namaFotoBaru = null;
        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            $namaFotoBaru = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/assets/barang', $namaFotoBaru);
        }

        // Generate kode unik
        $prefix   = strtoupper(substr(preg_replace('/\s+/', '', $nama_barang), 0, 3));
        $kode_brg = $prefix . '-' . date('Ymd') . '-' . rand(100, 999);

        $data = [
            'kode_brg'    => $kode_brg,
            'nama_brg'    => $nama_barang,
            'tipe_serie'  => $tipe_serie,
            'kategori_id' => $kategori_id,
            'merk'        => $merk_id,
            'jenis_brg'   => $jenis_brg,
            'spesifikasi' => $spesifikasi,
            'id_satuan'   => $id_satuan,
            'is_active'   => $is_active,
            'foto'        => $namaFotoBaru, // <<<<< field foto di sini
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $this->masterBarangModel->insert($data);

        // Insert pengecekan jika perlu
        if ($jenis_brg == 'hrd') {
            $dataPengecekan = [
                'id_inventaris'      => $kode_brg,
                'tanggal_pengecekan' => date('Y-m-d'),
                'ruangan_id_lama'    => null,
                'keterangan'         => 'Barang HRD baru, pengecekan awal',
            ];
            $this->pengecekanModel->insert($dataPengecekan);
        }

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin/master_barang');
    }

    public function detail_master_brg($id)
    {
        $data['title']        = 'Detail Master Barang';
        $data['master_brg']   = $this->masterBarangModel->getMasterBarang($id); // sudah join ke satuan
        $data['inventaris']   = $this->InventarisModel->where('id_master_barang', $id)->findAll();
        $data['barang_model'] = $this->BarangModel;
        // dd($data['master_brg']);
        return view('Admin/Master_barang/Detail_brg', $data);
    }
    public function detail_tipe_barang($id)
    {
        $data['title'] = 'Detail Master Barang';
        $barang        = $this->tipeBarangModel->getTipeBarang($id);
        if ($barang['jenis_brg'] == 'inv') {
            $data['detail_brg'] = $this->InventarisModel->detailMaster($id);
        } else {
            $data['detail_brg'] = $this->BarangModel->getMaster($id);
        }
        $data['master_brg'] = $barang;
        // dd($data['master_brg']);
        return view('Admin/Tipe_Barang/Detail_brg', $data);
    }

    public function ubah_master($id)
    {
        $data = [
            'title'      => 'Ubah Master Barang',
            'validation' => $this->validation,
            'master_brg' => $this->masterBarangModel->getMasterBarang($id),
            'satuan'     => $this->satuanModel->findAll(),
        ];
        // dd($data);
        return view('Admin/Master_barang/Edit_barang', $data);
    }
    public function editMaster()
    {
        $id = $this->request->getPost('kode_brg');

        $data = [
            'nama_brg'    => $this->request->getPost('nama_brg'),
            'merk'        => $this->request->getPost('merk'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'jenis_brg'   => $this->request->getPost('jenis_brg'),
            'id_satuan'   => $this->request->getPost('id_satuan'),
            'is_active'   => $this->request->getPost('is_active'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        $this->masterBarangModel->update($id, $data);

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/admin/master_barang');
    }

    // tipe barang
    public function master_tipe_barang()
    {
        $data = [
            'title'       => 'Master Tipe Barang',
            'tipe_barang' => $this->tipeBarangModel->getTipeBarang(),
        ];
        return view('Admin/Tipe_barang/Index', $data);
    }
    public function tambah_tipe_barang()
    {
        $data = [
            'title'         => 'Tambah Tipe Barang',
            'validation'    => $this->validation,
            'master_barang' => $this->masterBarangModel->findAll(),
        ];
        return view('Admin/Tipe_barang/Tambah_tipe', $data);
    }

    public function simpanTipe()
    {
        $data = [
            'tipe_barang'   => $this->request->getPost('tipe_barang'),
            'master_barang' => $this->request->getPost('kode_brg'),
        ];
        // dd($data);
        $this->tipeBarangModel->save($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin/master_tipe_barang');
    }

    public function editTipe($id)
    {
        $data = [
            'title'         => 'Ubah Tipe Barang',
            'validation'    => $this->validation,
            'tipe_barang'   => $this->tipeBarangModel->getTipeBarang($id),
            'master_barang' => $this->masterBarangModel->findAll(),
        ];
        return view('Admin/Tipe_barang/Edit_tipe', $data);
    }

    public function updateTipe()
    {
        $id   = $this->request->getPost('id');
        $data = [
            'tipe_barang'   => $this->request->getPost('tipe_barang'),
            'master_barang' => $this->request->getPost('kode_brg'),
        ];
        $this->tipeBarangModel->update($id, $data);
        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/admin/master_tipe_barang');
    }

    //Inventaris
    //     public function adm_inventaris()
    //     {
    //         // Group rekap: stok per barang per ruangan
    //         $rekap = $this->InventarisModel
    //             ->select('ruangan.nama_ruangan, master_barang.nama_brg, merk_barang.nama_merk, master_barang.jenis_brg, COUNT(inventaris.kode_barang) as stok')
    //             ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang')
    //             ->join('merk_barang', 'merk_barang.id = master_barang.merk_id', 'left')
    //             ->join('ruangan', 'ruangan.id = inventaris.ruangan_id', 'left')
    //             ->where('master_barang.is_active', 1)
    //             ->groupBy('ruangan.nama_ruangan, inventaris.id_master_barang')
    //             ->orderBy('ruangan.nama_ruangan, master_barang.nama_brg')
    //             ->findAll();

    //         // Detail: semua row per SN/unit
    //         $inventaris = $this->InventarisModel
    //             ->select('inventaris.*, master_barang.nama_brg, merk_barang.nama_merk, master_barang.jenis_brg, ruangan.nama_ruangan')
    //             ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang')
    //             ->join('merk_barang', 'merk_barang.id = master_barang.merk_id', 'left')
    //             ->join('ruangan', 'ruangan.id = inventaris.ruangan_id', 'left')
    //             ->where('master_barang.is_active', 1)
    //             ->findAll();

    //         $data['rekap']      = $rekap;
    //         $data['inventaris'] = $inventaris;
    //         $data['title']      = 'Rekap Inventaris';
    // // dd($data);
    //         return view('Admin/Inventaris/Index', $data);
    //     }
    public function adm_inventaris()
    {
        // 1. Ambil data flat: per kode_barang + ruangan, stok langsung dari field
        $rekap = $this->InventarisModel
            ->select('
            master_barang.kode_brg,
            master_barang.nama_brg,
            master_barang.merk,
            master_barang.tipe_serie,
            master_barang.jenis_brg,
            ruangan.nama_ruangan,
            inventaris.stok
        ')
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang')
            ->join('ruangan', 'ruangan.id = inventaris.ruangan_id', 'left')
            ->where('master_barang.is_active', 1)
            ->orderBy('master_barang.kode_brg, ruangan.nama_ruangan')
            ->findAll();

        // 2. Grouping by kode_barang (biar di view tampil sekali, lalu detail ruangan di bawahnya)
        $grouped = [];
        foreach ($rekap as $row) {
            $kode_barang = $row['kode_brg'];
            if (! isset($grouped[$kode_barang])) {
                $grouped[$kode_barang] = [
                    'nama_brg'   => $row['nama_brg'],
                    'merk'       => $row['merk'],
                    'tipe_serie' => $row['tipe_serie'] ?? '-',
                    'jenis_brg'  => $row['jenis_brg'],
                    'detail'     => [],
                ];
            }
            $grouped[$kode_barang]['detail'][] = [
                'ruangan' => $row['nama_ruangan'],
                'stok'    => $row['stok'],
            ];
        }

        $data['grouped_rekap'] = $grouped;
        $data['title']         = 'Rekap Inventaris';

        return view('Admin/Inventaris/Index', $data);
    }

    public function tambah_inv()
    {
        $data = [
            'validation'      => $this->validation,
            'title'           => 'Tambah Barang',
            'satuan'          => $this->satuanModel->findAll(),
            'master_barang'   => $this->masterBarangModel->getMasterBarang(),
            // 'merk_barang'   => $this->MerkBarangModel->findAll(),
            'daftarRuangan'   => $this->RuanganModel->findAll(),
            'kategori_barang' => $this->KategoriBarangModel->findAll(),

        ];
        // dd($data);
        return view('Admin/Inventaris/Tambah_barang', $data);
    }
    public function generate_qrcode($data_array)
    {
        if (! isset($data_array['kode_barang'])) {
            return ['error' => 'Kode barang tidak ditemukan dalam data'];
        }

        // Ambil master barang
        // DI CONTROLLER / LIBRARY
        $nama_barang = $this->masterBarangModel->getMasterInventory($data_array['id_master_barang']);

        if (! $nama_barang) {
            throw new \Exception("Data master barang tidak ditemukan untuk ID: " . $data_array['id_master_barang']);
        }

        // Gabung data ke QR
        $combined_data = "Kode Barang: " . $data_array['kode_barang'] . "\n";
        $combined_data .= "Nama Barang: " . ($nama_barang['nama_brg'] ?? '-') . "\n";
        $combined_data .= "Tipe Barang: " . ($nama_barang['tipe_barang'] ?? '-') . "\n";
        $combined_data .= "Kondisi Barang: " . ($data_array['kondisi'] ?? '-') . "\n";
        $combined_data .= "Merk Barang: " . ($nama_barang['merk'] ?? '-') . "\n";
        $combined_data .= "Spesifikasi: " . ($data_array['spesifikasi'] ?? '-') . "\n";

        // Slug aman
        $namaBarang = $nama_barang['nama_brg'] ?? 'noname';
        $slug       = url_title(($data_array['kode_barang'] ?? 'kd') . '-' . $namaBarang, '-', true);
        if (empty($slug)) {
            $slug = 'kd-' . date('YmdHis');
        }

        $unique_barcode = $slug . '_' . time();

        // Direktori simpan
        $dir = FCPATH . 'assets/media/qrcode/';
        if (! file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $filePath = $dir . $unique_barcode . '.png';

        $qrCode = QrCode::create($combined_data)->setSize(300);
        $logo   = Logo::create(FCPATH . 'assets/media/qrcode/tkj.png')->setResizeToWidth(60);

        $writer = new PngWriter();
        $result = $writer->write($qrCode, $logo);

        // Save to file
        $result->saveToFile($filePath);

        return [
            'unique_barcode' => $unique_barcode,
            'file'           => 'assets/media/qrcode/' . basename($filePath),
        ];
    }

    public function add_data()
    {
        $data             = $this->request->getPost();
        $user_id          = session()->get('user_id');
        $id_master_barang = $data['nama_barang'];
        $spesifikasi      = $data['spesifikasi'] ?? '';
        $id_satuan        = $data['id_satuan']; // ambil dari master_barang jika perlu

        $lokasi_list  = $data['lokasi'];  // array ruangan_id (bisa banyak row)
        $kondisi_list = $data['kondisi']; // array kondisi
        $jumlah_list  = $data['jumlah'];  // array jumlah

        try {
            for ($i = 0; $i < count($lokasi_list); $i++) {
                // Insert satu kali per kombinasi barang + lokasi + kondisi
                $this->InventarisModel->insert([
                    'id_master_barang' => $id_master_barang,
                    'spesifikasi'      => $spesifikasi,
                    'ruangan_id'       => $lokasi_list[$i],
                    'kondisi'          => $kondisi_list[$i],
                    'stok'             => $jumlah_list[$i],
                    'status'           => 'tersedia',
                    'created_at'       => date('Y-m-d H:i:s'),
                    'updated_at'       => date('Y-m-d H:i:s'),
                ]);

                // Opsional: insert ke histori transaksi (bisa diaktifkan jika perlu)
                $this->TransaksiBarangModel->insert([
                    'id_master_barang'   => $id_master_barang,
                    'jumlah_perubahan'   => $jumlah_list[$i],
                    'jenis_transaksi'    => 'masuk',
                    'informasi_tambahan' => "Tambah {$jumlah_list[$i]} unit, kondisi: {$kondisi_list[$i]}, lokasi: {$lokasi_list[$i]}",
                    'tanggal_transaksi' => date('Y-m-d H:i:s'),
                    'user_id'           => $user_id,
                ]);
            }

            session()->setFlashdata('PesanBerhasil', 'Penambahan Data Inventaris Berhasil!');
            return redirect()->to('/Admin/adm_inventaris');
        } catch (\Exception $e) {
            session()->setFlashdata('PesanGagal', 'Penambahan Data Inventaris Gagal: ' . $e->getMessage());
            return redirect()->to('/Admin/adm_inventaris');
        }
    }

    public function ubah($id = 0)
    {

        session();
        $data = [
            'title'         => "BPS Ubah Data inventaris",
            'validation'    => \Config\Services::validation(),
            'inventaris'    => $this->InventarisModel->getInventaris($id),
            'satuan'        => $this->satuanModel->findAll(),

            'master_barang' => $this->masterBarangModel->getMasterInventory(),
        ];
        // dd($data);
        return view('Admin/Inventaris/Edit_barang', $data);
    }
    public function update($id)
    {
        // Node 1: Ambil data dari formulir
        $data = $this->request->getPost();

        // Node 2: Validasi Form
        $validation = \Config\Services::validation();
        $validation->setRules([

            'nama_barang'   => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama barang wajib diisi.',
                ],
            ],
            'tgl_perolehan' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => 'Tanggal perolehan wajib diisi.',
                    'valid_date' => 'Format tanggal perolehan tidak valid.',
                ],
            ],
            // ... (aturan validasi untuk field lainnya)
        ]);

        if ($validation->run($data)) {
            // Node 3: Mengambil data inventaris yang sudah ada
            $existingData = $this->InventarisModel->getInventaris($id);

            if (! empty($existingData['qrcode'])) {
                $this->delete_qrcode($existingData['qrcode']);
            }

            // Node 4: Generate new QR Code
            $qr_data = [
                'kode_barang'      => $data['kode_barang'],
                'id_master_barang' => $data['nama_barang'], // Ganti 'id_master_barang' dengan 'nama_barang
                'kondisi'          => $data['kondisi'],
                'merk'             => $existingData['merk'],
                'spesifikasi'      => $data['spesifikasi'],
                'id_satuan'        => $data['id_satuan'],
                // 'jumlah_barang' => $data['jumlah_barang'],
                'tgl_perolehan'    => $data['tgl_perolehan'],
            ];

            // Generate new QR Code
            $newQrCode = $this->generate_qrcode($qr_data);

            // Node 5: Mengupdate data inventaris
            $this->InventarisModel->update_data($id, [
                'kode_barang'      => $data['kode_barang'],
                'id_master_barang' => $data['nama_barang'], // Ganti 'id_master_barang' dengan 'nama_barang
                'kondisi'          => $data['kondisi'],
                // 'merk' => $data['merk'],
                'spesifikasi'      => $data['spesifikasi'],
                'id_satuan'        => $data['id_satuan'],
                'lokasi'           => $data['lokasi'],
                // 'jumlah_barang' => $data['jumlah_barang'],
                'tgl_perolehan'    => $data['tgl_perolehan'],
                'qrcode'           => $newQrCode['unique_barcode'], // Sesuaikan dengan kembalian generate_qrcode
                'file'             => $newQrCode['file'],
            ]);

            // Node 6: Flashdata pesan disimpan
            session()->setFlashdata('pesanBerhasil', 'Data Berhasil Diubah');

            // Node 7: Redirect ke halaman index
            return redirect()->to('/Admin/adm_inventaris');
        } else {
            // Node 8: Ambil pesan kesalahan
            $errors = $validation->getErrors();

            // Tampilkan pesan kesalahan (bisa juga disimpan dan ditampilkan di formulir)
            foreach ($errors as $error) {
                echo $error . '<br>';
            }
        }

        // Node 9: Redirect kembali ke formulir dengan input
        return redirect()->back()->withInput();
    }

    public function detail_inv($id)
    {
        $data['title'] = 'Detail Barang Inventaris'; // Judul benerin

        $this->builder = $this->db->table('inventaris');
        $this->builder->select('inventaris.*, master_barang.nama_brg, satuan.nama_satuan, master_barang.merk');
        $this->builder->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang'); // INI YANG BENER!
        $this->builder->join('satuan', 'satuan.satuan_id = inventaris.id_satuan');
        $this->builder->where('inventaris.kode_barang', $id);

        $query              = $this->builder->get();
        $data['inventaris'] = $query->getRow();

        if (empty($data['inventaris'])) {
            return redirect()->to('/admin/adm_inventaris');
        }

        // dd($data); // Buat debug doang, matiin kalau udah jalan
        return view('Admin/Inventaris/Detail_inv', $data);
    }

    protected function delete_qrcode($unique_barcode)
    {
        $qrcode_path = 'assets/media/qrcode/' . $unique_barcode . '.png';

        // Hapus QR Code jika ada
        if (file_exists($qrcode_path)) {
            unlink($qrcode_path);
        }
    }

    public function delete($id)
    {
        // Get data before deletion for unlinking the file
        $inventaris = $this->InventarisModel->getInventaris($id);

        // Unlink file
        $fileLocation = FCPATH . $inventaris['file'];
        if (file_exists($fileLocation)) {
            unlink($fileLocation);
        }

        $this->InventarisModel->delete($id);

        // Set flashdata berdasarkan status penghapusan
        $flashdataKey     = ($this->db->affectedRows() > 0) ? 'PesanBerhasil' : 'PesanGagal';
        $flashdataMessage = ($this->db->affectedRows() > 0) ? 'Data Anda Berhasil Dihapus' : 'Gagal Menghapus Data';

        session()->setFlashdata($flashdataKey, $flashdataMessage);

        return redirect()->to('Admin/adm_inventaris');
    }

    //Akhir Inventaris

    public function lap_permintaan_barang()
    {
        $data = [
            // 'user'=> $query->getResult(),
            'title' => 'BPS - Laporan',

        ];

        return view('Admin/Laporan/Home_permintaan', $data);
    }

    public function cetakDataMasuk()
    {

        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        if (empty($tanggalMulai) || empty($tanggalAkhir)) {
            return redirect()->to(base_url('Admin'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
        }

        $dateMulai = strtotime($tanggalMulai);
        $dateAkhir = strtotime($tanggalAkhir);

        if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
            return redirect()->to(base_url('Admin'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
        }

        $transaksiBarangModel = new TransaksiBarangModel();
        $data['atk']          = $transaksiBarangModel
            ->withDeleted()
            ->select('transaksi_barang.*, satuan.nama_satuan, master_barang.nama_brg, barang.id_master_barang, barang.id_satuan, master_barang.merk,detail_master.tipe_barang')
            ->join('barang', 'transaksi_barang.kode_barang = barang.kode_barang')
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
            ->join('satuan', 'barang.id_satuan = satuan.satuan_id')
            ->where('transaksi_barang.tanggal_barang_masuk >=', $tanggalMulai . ' 00:00:00')
            ->where('transaksi_barang.tanggal_barang_masuk <=', $tanggalAkhir . ' 23:59:59')
            ->findAll();
        $data['tanggalMulai'] = $tanggalMulai; // Add this line
        $data['tanggalAkhir'] = $tanggalAkhir;

        // $dompdf = new \Dompdf\Dompdf();
        // $options = new \Dompdf\Options();
        // $options->setIsHtml5ParserEnabled(true);
        // $options->setIsPhpEnabled(true);
        // $dompdf->setOptions($options);

        // // Buat halaman PDF dengan data
        // $html = view('admin/laporan/lap_barangMasuk', $data); // Sesuaikan dengan view yang kamu miliki untuk laporan ATK
        // $dompdf->loadHtml($html);
        // $dompdf->setPaper('A4', 'landscape');

        // // Render PDF
        // $dompdf->render();

        // // Tampilkan atau unduh PDF
        // $dompdf->stream('Data_ATK.pdf', array('Attachment' => false));

        $mpdf                  = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html                  = view('Admin/Laporan/Lap_barangMasuk', $data);

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
        $mpdf->Output('Lap Barang Masuk Inventaris Barang.pdf', 'I');
    }

    public function cetakDataKeluar()
    {

        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        if (empty($tanggalMulai) || empty($tanggalAkhir)) {
            return redirect()->to(base_url('Admin'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
        }

        $dateMulai = strtotime($tanggalMulai);
        $dateAkhir = strtotime($tanggalAkhir);

        if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
            return redirect()->to(base_url('Admin'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
        }

        $transaksiBarangModel = new TransaksiBarangModel();

        $data['atkKeluar'] = $transaksiBarangModel
            ->withDeleted()
            ->select('transaksi_barang.*, satuan.nama_satuan, master_barang.nama_brg, barang.id_master_barang, barang.id_satuan, master_barang.merk,detail_master.tipe_barang')
            ->join('barang', 'transaksi_barang.kode_barang = barang.kode_barang')
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')

            ->join('satuan', 'barang.id_satuan = satuan.satuan_id')
            ->where('transaksi_barang.tanggal_barang_keluar >=', $tanggalMulai . ' 00:00:00') // Mengatur kondisi where untuk tanggal mulai
            ->where('transaksi_barang.tanggal_barang_keluar <=', $tanggalAkhir . ' 23:59:59') // Mengatur kondisi where untuk tanggal akhir
            ->findAll();

        $data['tanggalMulai']  = $tanggalMulai; // Add this line
        $data['tanggalAkhir']  = $tanggalAkhir;
        $mpdf                  = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html                  = view('Admin/Laporan/Lap_barangKeluar', $data);

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
        $mpdf->Output('Lap Barang Keluar Barang.pdf', 'I');
        // $dompdf = new \Dompdf\Dompdf();
        // $options = new \Dompdf\Options();
        // $options->setIsHtml5ParserEnabled(true);
        // $options->setIsPhpEnabled(true);
        // $dompdf->setOptions($options);

        // // Buat halaman PDF dengan data
        // $html = view('admin/laporan/lap_barangKeluar', $data); // Sesuaikan dengan view yang kamu miliki untuk laporan ATK
        // $dompdf->loadHtml($html);
        // $dompdf->setPaper('A4', 'landscape');

        // // Render PDF
        // $dompdf->render();

        // // Tampilkan atau unduh PDF
        // $dompdf->stream('Data_ATK.pdf', array('Attachment' => false));

    }
    //Akhir ATK

    // Permintaan Barang
    public function permintaan()
    {

        $this->builder = $this->db->table('permintaan_barang');
        $this->builder->select('*');
        $this->query        = $this->builder->get();
        $data['permintaan'] = $this->query->getResultArray();
        // dd(  $data['inventaris']);
        $data['title'] = 'Permintaan Barang';
        return view('Admin/Permintaan_barang/Index', $data);
    }
    public function list_permintaan($id)
    {
        $data['detail']     = $this->PermintaanModel->getPermintaan($id);
        $data['permintaan'] = $this->detailPermintaanModel
            ->select('peminjaman_detail.*, master_barang.nama_brg, satuan.nama_satuan,permintaan_barang.tanggal_permintaan, master_barang.merk,detail_master.tipe_barang')
            ->join('barang', 'barang.kode_barang = peminjaman_detail.kode_barang')
            ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
            ->join('permintaan_barang', 'permintaan_barang.permintaan_barang_id = peminjaman_detail.id_permintaan_barang')
            ->where('id_permintaan_barang', $id)->findAll();
        // dd(  $data['permintaan']);

        $data['title'] = 'Permintaan Barang';
        return view('Admin/Permintaan_barang/list_permintaan', $data);
    }
    public function permintaan_masuk()
    {
        $permintaan = $this->detailPermintaanModel->getDetailPermintaan();
        $data       = [
            'permintaan' => $permintaan,
            'title'      => 'Daftar permintaan - Masuk',
        ];
        return view('Admin/Permintaan_barang/Permintaan_masuk', $data);
    }
    public function permintaan_proses()
    {
        $permintaan = $this->detailPermintaanModel->getPermintaanProses();
        $data       = [
            'permintaan' => $permintaan,
            'title'      => 'Daftar permintaan - Masuk',
        ];
        return view('Admin/Permintaan_barang/Permintaan_masuk', $data);
    }
    public function permintaan_selesai()
    {
        $permintan = $this->detailPermintaanModel->getPermintaanSelesai();
        $data      = [
            'permintaan' => $permintan,
            'title'      => 'Daftar permintaan - Masuk',
        ];
        return view('Admin/Permintaan_barang/Permintaan_masuk', $data);
    }
    public function prosesPermintaan($id)
    {
        $date =
            $this->detailPermintaanModel->update($id, [
                'tanggal_diproses' => date("Y-m-d h:i:s"),
                'status'           => 'diproses',

            ]);
        session()->setFlashdata('msg', 'Status permintaan berhasil Diubah');
        return redirect()->to('Admin/detailpermin/' . $id);
    }

    public function terimaPermintaan($id)
    {

        $this->detailPermintaanModel->update($id, [
            'tanggal_selesai' => date("Y-m-d h:i:s"),
            'status'          => 'selesai',
            'status_akhir'    => 'diterima',

        ]);
        session()->setFlashdata('msg', 'Status permntaan berhasil Diubah');
        return redirect()->to('Admin/detailpermin/' . $id);
    }
    public function simpanBalasan($id)
    {
        $rules = [
            'kategori'           => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori  wajib diisi.',
                ],
            ],
            'balasan_permintaan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Isi Balasan wajib diisi.',

                ],
            ],

        ];

        if (! $this->validate($rules)) {
            $validation = \Config\Services::validation();
            return redirect()->to('/Admin/detail/' . $id)->withInput('validation', $validation);
        }
        $this->PermintaanModel->update($id, [
            'tanggal_selesai' => date("Y-m-d h:i:s"),
            'status'          => 'selesai',
            'status_akhir'    => 'ditolak',

        ]);
        $data = [
            'id_permintaan_barang' => $id,
            'kategori'             => $this->request->getPost('kategori'),
            'balasan_permintaan'   => $this->request->getPost('balasan_permintaan'),

        ];
        $this->BalasanModel->save($data);
        session()->setFlashdata('msg', 'Status Permintaan berhasil Diubah');
        return redirect()->to('Admin/detailpermin/' . $id);
    }
    public function detailpermin($id)
    {
        $barangList = $this->BarangModel->findAll();
        $data       = $this->detailPermintaanModel->getDetailPermintaan($id);

        $d = $this->db->table('balasan_permintaan');
        $d->select('*');
        $d->where('id_permintaan_barang', $id);
        $balasan = $d->get()->getRow();

        // dd($query1);
        $ex = [

            'detail'     => $data,
            'title'      => 'Detail permintaan',
            'balasan'    => $balasan,
            'barangList' => $barangList,
            'validation' => \Config\Services::validation(),

        ];

        return view('Admin/Permintaan_barang/Detail_permintaan', $ex);
    }

    public function cetakDataPdf() //permintaan
    {
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        // Validasi tanggal
        if (empty($tanggalMulai) || empty($tanggalAkhir)) {
            return redirect()->to(base_url('Admin'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
        }

        $dateMulai = strtotime($tanggalMulai);
        $dateAkhir = strtotime($tanggalAkhir);

        if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
            return redirect()->to(base_url('Admin'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
        }

        $permintaanModel    = new PermintaanModel();
        $data['permintaan'] = $permintaanModel
            ->select('id_user, kode_barang, id_balasan_permintaan, nama_pengaju, perihal, detail, tanggal_pengajuan, tanggal_diproses, tanggal_selesai, status, status_akhir')
            ->where('tanggal_pengajuan >=', $tanggalMulai . ' 00:00:00')
            ->where('tanggal_pengajuan <=', $tanggalAkhir . ' 23:59:59')
            ->findAll();

        // Load library DomPDF
        $dompdf  = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();
        $options->setIsHtml5ParserEnabled(true);
        $options->setIsPhpEnabled(true);
        $dompdf->setOptions($options);

        // Buat halaman PDF dengan data
        $html = view('Admin/Laporan/Lap_permintaan', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $dompdf->render();

        // Tampilkan atau unduh PDF
        $dompdf->stream('Data.pdf', ['Attachment' => false]);
    }
    // public function print() // all data
    // {
    //     $data = [
    //         'permintaan_barang' => $this->PermintaanModel->getAll(),
    //         'title' => 'Cetak Data',
    //     ];

    //     $dompdf = new \Dompdf\Dompdf();
    //     $options = new \Dompdf\Options();
    //     $options->setIsRemoteEnabled(true);

    //     $dompdf->setOptions($options);
    //     $dompdf->output();
    //     $dompdf->loadHtml(view('user/permintaan_barang/print', $data));
    //     $dompdf->setPaper('A4', 'landscape');
    //     $dompdf->render();
    //     ini_set('max_execution_time', 0);
    //     $dompdf->stream('Data.pdf', array("Attachment" => false));
    // }
    //Akhir Permintaan

    //Pengadaan Barang
    public function pengadaan()
    {

        $this->builder = $this->db->table('pengadaan_barang');
        $this->builder->select('*');
        $this->builder->where('id_user', user()->id);
        $this->query       = $this->builder->get();
        $data['pengadaan'] = $this->query->getResultArray();
        // dd(  $data['inventaris']);
        $data['title'] = 'Pengadaan Barang';

        return view('Admin/Pengadaan/Index', $data);
    }

    public function tambah_pengadaan()
    {
        $data = [
            'validation' => $this->validation,
            'title'      => 'Tambah Pengadaan Barang',

        ];
        return view('Admin/Pengadaan/Tambah_pengadaan', $data);
    }
    public function simpanPengadaan()
    {
        // get data post add data post
        $data = $this->request->getPost();
        // dd($data);
        // post to pengadaan
        $id_pengadaan = 'PG-' . date('Ymdhis') . rand(100, 999);
        $this->PengadaanModel->save([
            'id_user'             => user()->id,
            'pengadaan_barang_id' => $id_pengadaan,
            'tanggal_pengadaan'   => date("Y/m/d"),
            'tahun_periode'       => $data['tahun_periode'],

        ]);
        // get id_pengadaan
        for ($i = 0; $i < count($data['nama_barang']); $i++) {
            $this->detailPengadaanModel->save([
                'id_pengadaan_barang' => $id_pengadaan,
                'nama_barang'         => $data['nama_barang'][$i],
                'jumlah'              => $data['jumlah'][$i],
                'spesifikasi'         => $data['spesifikasi'][$i],
                'alasan_pengadaan'    => $data['alasan_pengadaan'][$i],
                'nama_pengaju'        => user()->username,
                'tgl_pengajuan'       => date("Y/m/d h:i:s"),

                'status'              => 'belum diproses',
            ]);
            // dd($data);
        }

        // Flashdata pesan disimpan
        session()->setFlashdata(
            'pesanBerhasil',
            'Data Pengadaan Berhasil Ditambahkan'
        );
        return redirect()->to('/Admin/pengadaan');

        // Flashdata pesan disimpan
        session()->setFlashdata(
            'pesanBerhasil',
            'Data Pengadaan Berhasil Ditambahkan'
        );
        return redirect()->to('/Admin/pengadaan');
    }

    public function editPengadaan($id)
    {
        $validation = \Config\Services::validation();

        $data['pengadaan']  = $this->detailPengadaanModel->getDetailPengadaan($id);
        $data['validation'] = $validation;      // Pass the validation service to the view
        $data['title']      = 'Ubah Pengadaan'; // Pass the validation service to the view

        // Cek apakah pengadaan dengan id tersebut ditemukan
        if (! $data['pengadaan']) {
            // Redirect atau tampilkan pesan error jika tidak ditemukan
            return redirect()->to('/Admin/pengadaan')->with('pesanError', 'Pengadaan tidak ditemukan');
        }

        // Tampilkan formulir edit dengan data pengadaan
        return view('Admin/Pengadaan/Edit_pengadaan', $data);
    }

    public function updatePengadaan($id)
    {
        // Validasi input
        if (! $this->validate([
            'alasan_pengadaan' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'alasan_pengadaan wajib di isi',
                ],
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to("/Admin/editPengadaan/$id")->withInput()->with('validation', $validation);
        }

        // Dapatkan data pengadaan dari database
        $pengadaan = $this->detailPengadaanModel->getDetailPengadaan($id);

        // Cek apakah pengadaan dengan id tersebut ditemukan
        if (! $pengadaan) {
            // Redirect atau tampilkan pesan error jika tidak ditemukan
            return redirect()->to('/Admin/pengadaan')->with('pesanError', 'Pengadaan tidak ditemukan');
        }

        // Persiapkan data untuk disimpan
        $dataPengadaan = [
            'nama_barang'      => $this->request->getPost('nama_barang'),
            'jumlah'           => $this->request->getPost('jumlah'),
            'spesifikasi'      => $this->request->getPost('spesifikasi'),
            'alasan_pengadaan' => $this->request->getPost('alasan_pengadaan'),
            'nama_pengaju'     => user()->username,
        ];

        // Update data ke database
        $this->detailPengadaanModel->update($id, $dataPengadaan);

        // Flashdata pesan berhasil diupdate
        session()->setFlashdata('pesanBerhasil', 'Data Pengadaan Berhasil Diupdate');
        return redirect()->to('/Admin/detailPengadaan/' . $this->request->getPost('id_pengadaan_barang'));
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

            'detail'     => $data,
            'title'      => 'Detail Pengadaan',
            'balasan'    => $balasan,
            'validation' => \Config\Services::validation(),

        ];

        return view('Admin/Pengadaan/detail', $ex);
    }

    public function detailPengadaan($id)
    {

        $dataPengadaan     = $this->PengadaanModel->getPengadaan($id);
        $detail_pengadaaan = $this->detailPengadaanModel->where('id_pengadaan_barang', $id)->findAll();

        $ex = [

            'title'             => 'Detail Pengadaan Barang',
            'detail'            => $dataPengadaan,
            'detail_pengadaaan' => $detail_pengadaaan,

        ];

        return view('Admin/Pengadaan/Detail_pengadaan', $ex);
    }
    public function deletePengadaan($id)
    {
        // dd($id);
        $this->PengadaanModel->hapusPengadaan($id);
        session()->setFlashdata('pesanBerhasil', 'Data Berhasil Dihapus');

        // Redirect ke halaman index
        return redirect()->to('/Admin/pengadaan');
    }

    public function printPB() // all data
    {
        $data = [
            'pengadaan' => $this->PengadaanModel->getAll(),
            'title'     => 'Cetak Data',
        ];

        $dompdf  = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);

        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml(view('user/pengadaan/print', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ini_set('max_execution_time', 0);
        $dompdf->stream('Data.pdf', ["Attachment" => false]);
    }
    public function eksporPB($id) //detail permintaan
    {
        // $aduan = $this->pengaduan->where(['id' => $id])->first();
        // $id = $id;
        // $data['detail']   = $aduan;
        $data['title']  = 'cetak';
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
        $dompdf->stream('Detail Pengadaan.pdf', ["Attachment" => false]);
    }
    //Akhir Pengadaan
    // AKhir

    //Laporan

    public function lap_permintaan()
    {
        $data = [
            // 'user'=> $query->getResult(),
            'title' => 'BPS - Laporan',

        ];

        return view('Admin/Laporan/Index', $data);
    }

    public function lap_masuk()
    {
        $data = [
            // 'user'=> $query->getResult(),
            'title' => 'BPS - Laporan',

        ];

        return view('Admin/Laporan/Home_transaksimasuk', $data);
    }
    public function lap_keluar()
    {
        $data = [
            // 'user'=> $query->getResult(),
            'title' => 'BPS - Laporan',

        ];

        return view('Admin/Laporan/Home_transaksikeluar', $data);
    }
    //Pengadaan
    public function lap_pengadaan()
    {
        $data = [
            // 'user'=> $query->getResult(),
            'title' => 'BPS - Laporan Pengadaan Barang',

        ];

        return view('Admin/Laporan/Home_pengadaan', $data);
    }

    public function cetakDataPengadaan()
    {

        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        // Validasi tanggal
        if (empty($tanggalMulai) || empty($tanggalAkhir)) {
            return redirect()->to(base_url('Admin'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
        }

        $dateMulai = strtotime($tanggalMulai);
        $dateAkhir = strtotime($tanggalAkhir);

        if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
            return redirect()->to(base_url('Admin'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
        }

        $pengadaanModel    = new PengadaanModel();
        $data['pengadaan'] = $pengadaanModel
            ->select('id, id_user, id_balasan_pengadaan, nama_pengaju, nama_barang, spesifikasi, jumlah, tahun_periode, alasan_pengadaan, tgl_pengajuan, tgl_proses, tgl_selesai, status, status_akhir')
            ->where('tgl_pengajuan >=', $tanggalMulai . ' 00:00:00')
            ->where('tgl_pengajuan <=', $tanggalAkhir . ' 23:59:59')
            ->findAll();
        $data['tanggalMulai'] = $tanggalMulai; // Add this line
        $data['tanggalAkhir'] = $tanggalAkhir;

        $mpdf                  = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html                  = view('Admin/Laporan/Lap_pengadaan', $data);

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
    // Pengadaan

    //laporan_inventaris
    public function lap_inventaris()
    {
        $data = [
            'title' => 'BPS - Laporan Inventaris',
        ];

        return view('Admin/Laporan/Home_inventaris', $data);
    }
    public function lap_qr()
    {
        $data = [
            'title' => 'BPS - Cetak QR Inventaris',
        ];

        return view('Admin/Laporan/Home_qr', $data);
    }

    // public function cetakDataInventaris()
    // {
    //     //     $tanggalMulai = $this->request->getGet('tanggal_mulai');
    //     //     $tanggalAkhir = $this->request->getGet('tanggal_akhir');

    //     //     // Validasi tanggal
    //     //     if (empty($tanggalMulai) || empty($tanggalAkhir)) {
    //     //         return redirect()->to(base_url('admin'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
    //     //     }

    //     //     $dateMulai = strtotime($tanggalMulai);
    //     //     $dateAkhir = strtotime($tanggalAkhir);

    //     //     if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
    //     //         return redirect()->to(base_url('admin'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
    //     //     }

    //     //     $inventarisModel = new InventarisModel(); // Change to your actual model name
    //     //     $data['inventaris'] = $inventarisModel
    //     //         ->select('id, kode_barang, nama_barang, kondisi, merk, tipe, satuan_barang, jumlah_barang, tgl_perolehan, qrcode, file, created_at, updated_at, deleted_at')
    //     //         ->where('tgl_perolehan >=', $tanggalMulai . ' 00:00:00')
    //     //         ->where('tgl_perolehan <=', $tanggalAkhir . ' 23:59:59')
    //     //         ->findAll();

    //     //     // Load library DomPDF
    //     //     $dompdf = new \Dompdf\Dompdf();
    //     //     $options = new \Dompdf\Options();
    //     //     $options->setIsHtml5ParserEnabled(true);
    //     //     $options->setIsPhpEnabled(true);
    //     //     // $options->setIsRemoteEnabled(true);
    //     //     $dompdf->setOptions($options);

    //     //     // Buat halaman PDF dengan data
    //     //     return view('admin/laporan/lap_inventaris', $data); // Update view path accordingly
    //     //     $dompdf->loadHtml($html);
    //     //     $dompdf->setPaper('A4', 'landscape');

    //     //     // Render PDF
    //     //     $dompdf->render();

    //     //     // Tampilkan atau unduh PDF
    //     //     $dompdf->stream('Data_Inventaris.pdf', array('Attachment' => true));

    //     // }

    //     $tanggalMulai = $this->request->getGet('tanggal_mulai');
    //     $tanggalAkhir = $this->request->getGet('tanggal_akhir');

    //     // Validasi tanggal
    //     if (empty($tanggalMulai) || empty($tanggalAkhir)) {
    //         return redirect()->to(base_url('admin'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
    //     }

    //     $dateMulai = strtotime($tanggalMulai);
    //     $dateAkhir = strtotime($tanggalAkhir);

    //     if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
    //         return redirect()->to(base_url('admin'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
    //     }

    //     $inventarisModel = new InventarisModel();
    //     $inventaris = $inventarisModel
    //         ->select('id, kode_barang, nama_barang, kondisi, merk, tipe, satuan_barang, jumlah_barang, tgl_perolehan, qrcode, file, created_at, updated_at, deleted_at')
    //         ->where('tgl_perolehan >=', $tanggalMulai . ' 00:00:00')
    //         ->where('tgl_perolehan <=', $tanggalAkhir . ' 23:59:59')
    //         ->findAll();

    //     // Load library FPDF
    //     require_once ROOTPATH . 'vendor/setasign/fpdf/fpdf.php';

    //     $pdf = new \FPDF();

    //     // Buat halaman PDF dengan data
    //     $pdf->AddPage();
    //     $pdf->SetFont('Arial', 'B', 16);

    //     // Tambahkan header
    //     $pdf->Ln(10);
    //     $pdf->Cell(20, 10, 'No', 1);
    //     $pdf->Cell(40, 10, 'Gambar', 1);
    //     $pdf->Cell(40, 10, 'Created At', 1);
    //     $pdf->Cell(40, 10, 'Updated At', 1);
    //     $pdf->Cell(40, 10, 'Deleted At', 1);

    //     // Tambahkan data inventaris ke PDF
    //     // $x_awal = 0;

    //     // foreach ($inventaris as $row) {
    //     //     $pdf->Ln();
    //     //     $pdf->Cell(20, 10, $row['id'], 1);
    //     //     // $n= $pdf->Image($row['file'], $x_awal, $x_awal, -300);

    //     //     // $pdf->Cell(40, 10, $n, 1); // Placeholder for image, adjust as needed
    //     //     $x_awal = $x_awal+300;
    //     //     // Tambahkan gambar ke PDF jika ada
    //     //     if (!empty($row['file'])) {
    //     //         $gambarPath = FCPATH  . $row['file'];
    //     //         if (file_exists($gambarPath)) {
    //     //             $pdf->Image($gambarPath, $pdf->GetX() + 1, $pdf->GetY() + 20, 38, 38);
    //     //         }
    //     //     } else {
    //     //         $pdf->Cell(40, 10, 'Gambar tidak tersedia', 1);
    //     //     }

    //     //     $pdf->Cell(40, 10, $row['created_at'], 1);
    //     //     $pdf->Cell(40, 10, $row['updated_at'], 1);
    //     //     $pdf->Cell(40, 10, $row['deleted_at'], 1);
    //     // }
    //     $x_awal = 0;

    //     foreach ($inventaris as $row) {
    //         $pdf->Ln();
    //         $pdf->Cell(20, 10, $row['id'], 1);
    //         $x_awal = $x_awal + 300;

    //         // Tambahkan gambar ke PDF jika ada
    //         if (!empty($row['file'])) {
    //             $gambarPath = FCPATH . $row['file'];
    //             if (file_exists($gambarPath)) {
    //                 $pdf->Image($gambarPath, $pdf->GetX() + 1, $pdf->GetY() + 20, 38, 38);
    //             }
    //         } else {
    //             $pdf->Cell(40, 10, 'Gambar tidak tersedia', 1);
    //         }

    //         $pdf->Cell(40, 10, $row['created_at'], 1);
    //         $pdf->Cell(40, 10, $row['updated_at'], 1);
    //         $pdf->Cell(40, 10, $row['deleted_at'], 1);
    //     }

    //     // Simpan atau keluarkan PDF
    //     $pdf->Output('Data_Inventaris.pdf', 'I');
    //     exit;

    // }

    public function cetak_qr()
    {
        ini_set('max_execution_time', 0);
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        // Validasi tanggal
        if (empty($tanggalMulai) || empty($tanggalAkhir)) {
            return redirect()->to(base_url('Admin'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
        }

        $dateMulai = strtotime($tanggalMulai);
        $dateAkhir = strtotime($tanggalAkhir);

        if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
            return redirect()->to(base_url('Admin'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
        }

        $inventarisModel = new InventarisModel(); // Ganti dengan nama model yang sesuai
        $this->builder   = $this->db->table('inventaris');
        $this->builder->select('inventaris.*, master_barang.nama_brg, satuan.nama_satuan, master_barang.merk, detail_master.tipe_barang');
        $this->builder->join('detail_master', 'detail_master.detail_master_id = inventaris.id_master_barang');
        $this->builder->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang');
        $this->builder->join('satuan', 'satuan.satuan_id = inventaris.id_satuan');
        $this->builder->where('inventaris.tgl_perolehan >=', $tanggalMulai . ' 00:00:00');
        $this->builder->where('inventaris.tgl_perolehan <=', $tanggalAkhir . ' 23:59:59');

        $data['inventaris'] = $this->builder->get()->getResultArray();

        $mpdf                  = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html                  = view('Admin/Laporan/Lap_qr', $data);

        $mpdf->setAutoPageBreak(true);

        $options = [
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ],
        ];

        $mpdf->AddPageByArray(['orientation' => 'P'] + $options);

        $mpdf->WriteHtml($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Lap_QR_ Inventaris Barang.pdf', 'I');
    }

    public function cetak_qr_id($id)
    {
        ini_set('max_execution_time', 0);

        $data['title']      = 'cetak';
        $data['inventaris'] = $this->InventarisModel->where(['kode_barang' => $id])->first();

        if (empty($data['inventaris'])) {
            // Handle the case when no data is found for the given kode_barang
            return redirect()->to(base_url('Admin'))->with('error', 'Data not found for kode_barang: ' . $id);
        }

        $mpdf                  = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html                  = view('Admin/Laporan/Kode_qr', $data);
        $mpdf->setAutoPageBreak(true);

        $options = [
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ],
        ];

        $mpdf->AddPageByArray(['orientation' => 'P'] + $options);
        $mpdf->WriteHtml($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Lap_QR_Inventaris_Barang.pdf', 'I');
    }

    public function cetakPengadaan($kode_pengadaan)
    {
        $pengadaanModel    = new PengadaanModel();
        $data['pengadaan'] = $pengadaanModel
            ->select('*')
            ->where('pengadaan_barang_id', $kode_pengadaan)
            ->first();

        if (empty($data['pengadaan'])) {
            // Handle the case when no data is found for the given kode_pengadaan
            return redirect()->to(base_url('Admin'))->with('error', 'Data not found for kode_pengadaan: ' . $kode_pengadaan);
        }

        $detailPengadaan          = new DetailPengadaanModel();
        $data['detail_pengadaan'] = $detailPengadaan
            ->select('detail_pengadaan_barang.*, pengadaan_barang.tahun_periode, pengadaan_barang.tanggal_pengadaan')
            ->join('pengadaan_barang', 'pengadaan_barang.pengadaan_barang_id = detail_pengadaan_barang.id_pengadaan_barang')
            ->where('id_pengadaan_barang', $kode_pengadaan)
            ->findAll();

        $mpdf                  = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html                  = view('Admin/Laporan/cetak_pengadaan', $data);

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

    public function cetak_lap_inv()
    {
        ini_set('max_execution_time', 0);
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        // Validasi tanggal
        if (empty($tanggalMulai) || empty($tanggalAkhir)) {
            return redirect()->to(base_url('Admin'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
        }

        $dateMulai = strtotime($tanggalMulai);
        $dateAkhir = strtotime($tanggalAkhir);

        if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
            return redirect()->to(base_url('Admin'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
        }

        $inventarisModel    = new InventarisModel(); // Ganti dengan nama model yang sesuai
        $data['inventaris'] = $inventarisModel
            ->select('inventaris.*,master_barang.nama_brg, satuan.nama_satuan, master_barang.merk')
            ->join('detail_master', 'detail_master.detail_master_id = inventaris.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
            ->join('satuan', 'satuan.satuan_id = inventaris.id_satuan')
            // ->where('inventaris.tgl_perolehan >=', $tanggalMulai . ' 00:00:00')
            // ->where('inventaris.tgl_perolehan <=', $tanggalAkhir . ' 23:59:59')
            // tangal peminjaman
            ->findAll();
        // dd($data['inventaris']);
        $data['tanggalMulai'] = $tanggalMulai; // Add this line
        $data['tanggalAkhir'] = $tanggalAkhir;

        $mpdf                  = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html                  = view('Admin/Laporan/Lap_inventaris', $data);

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
        $mpdf->Output('Lap Inventaris Barang.pdf', 'I');
    }

    //laporan inventaris

    //Laporan Barang
    public function lap_barang()
    {
        $data = [
            'title' => 'BPS - Laporan Barang',
        ];

        return view('Admin/Laporan/Home_barang', $data);
    }

    public function cetakDataBarang()
    {
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        // Validasi tanggal
        if (empty($tanggalMulai) || empty($tanggalAkhir)) {
            return redirect()->to(base_url('Admin'))->with('error', 'Tanggal mulai dan tanggal akhir harus diisi.');
        }

        $dateMulai = strtotime($tanggalMulai);
        $dateAkhir = strtotime($tanggalAkhir);

        if ($dateMulai === false || $dateAkhir === false || $dateMulai > $dateAkhir) {
            return redirect()->to(base_url('Admin'))->with('error', 'Format tanggal tidak valid atau tanggal mulai melebihi tanggal akhir.');
        }
        $barangModel    = new BarangModel();
        $data['barang'] = $barangModel
            ->select('barang.*,master_barang.nama_brg, satuan.nama_satuan, master_barang.merk, detail_master.tipe_barang')
            ->join('detail_master', 'detail_master.detail_master_id = barang.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
            ->join('satuan', 'satuan.satuan_id = barang.id_satuan')
            ->where('tanggal_barang_masuk >=', $tanggalMulai . ' 00:00:00')
            ->where('tanggal_barang_masuk <=', $tanggalAkhir . ' 23:59:59')
            ->findAll();
        $data['tanggalMulai'] = $tanggalMulai; // Add this line
        $data['tanggalAkhir'] = $tanggalAkhir;
        // Load library DomPDF
        // $dompdf = new \Dompdf\Dompdf();
        // $options = new \Dompdf\Options();
        // $options->setIsHtml5ParserEnabled(true);
        // $options->setIsPhpEnabled(true);
        // $dompdf->setOptions($options);

        // // Buat halaman PDF dengan data
        // $html = view('admin/laporan/lap_barang', $data); // Sesuaikan dengan view yang Anda miliki untuk laporan barang
        // $dompdf->loadHtml($html);
        // $dompdf->setPaper('A4', 'landscape');

        // // Render PDF
        // $dompdf->render();

        // // Tampilkan atau unduh PDF
        // $dompdf->stream('Data_Barang.pdf', array('Attachment' => false));

        $mpdf                  = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html                  = view('Admin/Laporan/Lap_barang', $data);

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
        $mpdf->Output('Lap Data Barang Barang.pdf', 'I');
    }

    // tambah user
    public function kelola_user()
    {
        $userModel     = new UserModel();
        $data['users'] = $userModel->findAll();

        $groupModel = new GroupModel();

        foreach ($data['users'] as $row) {
            $dataRow['group']       = $groupModel->getGroupsForUser($row->id);
            $dataRow['row']         = $row;
            $data['row' . $row->id] = view('Admin/User/Row', $dataRow);
        }
        $data['groups'] = $groupModel->findAll();
        $data['title']  = 'Daftar Pengguna';
        return view('Admin/User/Index', $data);
    }

    public function tambah_user()
    {

        $data = [
            'title' => 'BPS - Tambah Users',
        ];
        return view('/Admin/User/Tambah', $data);
    }

    public function changeGroup()
    {
        $userId     = $this->request->getVar('id');
        $groupId    = $this->request->getVar('group');
        $groupModel = new GroupModel();
        $groupModel->removeUserFromAllGroups(intval($userId));
        $groupModel->addUserToGroup(intval($userId), intval($groupId));
        return redirect()->to(base_url('/Admin/kelola_user'));
    }

    public function changePassword()
    {
        $userId = $this->request->getVar('user_id');

        $password_baru = $this->request->getVar('password_baru');
        $userModel     = new \App\Models\User();
        $user          = $userModel->getUsers($userId);
        // $dataUser->update($userId, ['password_hash' => password_hash($password_baru, PASSWORD_DEFAULT)]);
        $userEntity           = new User($user);
        $userEntity->password = $password_baru;
        $userModel->save($userEntity);
        return redirect()->to(base_url('Admin/kelola_user'));
    }

    public function activateUser($id, $active)
    {
        $userModel = new UserModel();
        $user      = $userModel->find($id);

        if ($user) {
            $userModel->update($id, ['active' => $active]);
            return redirect()->back()->with('success', 'Status pengguna berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }
    }

    // pengecekan
    public function pengecekan($id)
    {
        $data = [
            'title'  => 'Pengecekan',
            'barang' => $this->InventarisModel->getInventaris($id),
        ];
        return view('Admin/Pengecekan/Index', $data);
    }
    public function simpanPengecekan()
    {
        $data = $this->request->getPost();
        $data = [
            'id_inventaris'      => $data['id_inventaris'],
            'tanggal_pengecekan' => date("Y-m-d"),
            'keterangan'         => $data['keterangan'],
            'lokasi_lama'        => $data['lokasi_barang'],
            // 'lokasi_baru' => $data['lokasi'],
        ];
        // dd($data);
        // update lokasi inventaris
        $this->InventarisModel->update($data['id_inventaris'], ['lokasi' => $this->request->getPost('lokasi')]);
        $this->pengecekanModel->save($data);
        // dd($data);
        session()->setFlashdata('pesanBerhasil', 'Data Pengecekan Berhasil Ditambahkan');
        return redirect()->to('/Admin/adm_inventaris');
    }

    public function lap_ruangan()
    {
        $data = [
            'title' => 'BPS - Laporan Barang Per ruangan',
        ];

        return view('Admin/Laporan/Home_ruangan', $data);
    }
    public function cetak_ruangan()
    {
        ini_set('max_execution_time', 0);

        $lokasi = $this->request->getGet('lokasi');

        if (empty($lokasi)) {
            return redirect()->to(base_url('Admin'))->with('error', 'Lokasi harus diisi.');
        }

        $inventarisModel    = new InventarisModel();
        $data['inventaris'] = $inventarisModel
            ->select('inventaris.*, master_barang.nama_brg,master_barang.kode_brg, detail_master.tipe_barang,satuan.nama_satuan, master_barang.merk')
            ->join('detail_master', 'detail_master.detail_master_id = inventaris.id_master_barang')
            ->join('master_barang', 'master_barang.kode_brg = detail_master.master_barang')
            ->join('satuan', 'satuan.satuan_id = inventaris.id_satuan')
            ->where('inventaris.lokasi', $lokasi)
            ->findAll();

        $data['lokasi'] = $lokasi;

        $mpdf                  = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;

        $html = view('Admin/Laporan/Lap_Ruangan', $data);

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
        $mpdf->Output('Lap Inventaris Barang Ruangan.pdf', 'I');
    }

    public function Scan()
    {
        $data = [
            'title' => 'Scan QR',
        ];
        return view('Admin/Scan/index', $data);
    }

    public function transaksiBarang()
    {
        $transaksi = $this->TransaksiBarangModel
            ->select('
        transaksi_barang.*,
        inventaris.kode_barang,
        inventaris.kondisi,
        inventaris.lokasi,
        inventaris.spesifikasi AS spek_real,
        master_barang.nama_brg,
        master_barang.merk,
        master_barang.spesifikasi AS spek_master,
        master_barang.jenis_brg,
        satuan.nama_satuan,
        users.username AS user_name
    ')
            ->join('inventaris', 'inventaris.kode_barang = transaksi_barang.kode_barang', 'left')
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang', 'left')
            ->join('satuan', 'satuan.satuan_id = inventaris.id_satuan', 'left')
            ->join('users', 'users.id = transaksi_barang.user_id', 'left')
            ->orderBy('transaksi_barang.tanggal_transaksi', 'desc')
            ->findAll();

        $data = [
            'title'      => 'Histori Transaksi Barang',
            'transaksis' => $transaksi,
        ];

        // dd($data);
        return view('Admin/TransaksiBarang/Index', $data);
    }

    public function peminjaman()
    {
        $status = $this->request->getGet('status') ?? 'all'; // ambil dari query param

        $builder = $this->PeminjamanHeaderModel
            ->select('peminjaman_header.*, users.username as peminjam')
            ->join('users', 'users.id = peminjaman_header.id_user', 'left')
            ->orderBy('peminjaman_header.tanggal_permintaan', 'desc');

        if ($status && $status != 'all') {
            $builder->where('peminjaman_header.status', $status);
        }

        $peminjamans = $builder->findAll();
        $data        = [
            'title'       => 'Peminjaman Alat',
            'peminjamans' => $peminjamans,
            'status'      => $status,
        ];
        return view('Admin/Peminjaman/Index', $data);
    }

    public function tambahPeminjaman()
    {
        $status = $this->request->getGet('status') ?? 'all';
        $users   = $this->Profil->findAll();
        $barangs = $this->InventarisModel
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang', 'left')
            ->where('inventaris.stok >', 0)
            ->findAll();

        $ruangan = $this->RuanganModel->findAll();
        $mapRuangan = [];
        foreach ($ruangan as $r) {
            $mapRuangan[$r['id']] = $r['nama_ruangan'];
        }
        $data = [
            'users' => $users,
            'barangs' => $barangs,
            'title' => 'Tambah Peminjaman',
            'ruangan' => $ruangan,
            'mapRuangan' => $mapRuangan,
            'status' => $status,
        ];

        // dd($data);
        return view('Admin/Peminjaman/Tambah', $data);
    }

    public function savePeminjaman1()
    {
        $db = db_connect();

        // Ambil input dari form
        $barangArr       = $this->request->getPost('barang'); // array: barang[0][kode], barang[0][ruangan_id], dst
        $catatan         = $this->request->getPost('catatan');
        $ruanganTujuanId = $this->request->getPost('ruangan_id'); // ruangan tujuan pinjam
        $ruanganSebelum = isset($barangArr[0]['ruangan_id']) ? $barangArr[0]['ruangan_id'] : null;

        if (empty($barangArr) || ! is_array($barangArr)) {
            return redirect()->back()->with('error', 'Barang belum dipilih');
        }
        $db->transStart();
        $headerData = [
            'kode_transaksi'          => 'PINJAM-' . date('YmdHis'),
            'tanggal_permintaan'      => date('Y-m-d H:i:s'),
            'tanggal_pinjam'          => date('Y-m-d'),
            'tanggal_kembali_rencana' => date('Y-m-d', strtotime('+3 days')),
            'tanggal_kembali_real'    => null,
            'id_user'                 => user()->id,
            'approved_by'             => user()->id,
            'ruangan_id_pinjam'       => $ruanganTujuanId,
            'ruangan_id_sebelum'      => $ruanganSebelum,
            'status'                  => 'approved',
            'catatan'                 => $catatan,
        ];
        $db->table('peminjaman_header')->insert($headerData);
        $peminjaman_id = $db->insertID();

        // 2️⃣ Insert Detail Barang (GA ADA field 'status')
        foreach ($barangArr as $barang) {
            $kode_barang = $barang['kode'];
            $ruangan_id  = $barang['ruangan_id'];

            // Optional: cek inventaris valid, status ready, dsb
            $inventaris = $db->table('inventaris')
                ->where('id', $kode_barang)
                ->where('ruangan_id', $ruangan_id)
                ->get()
                ->getRowArray();

            if ($inventaris) {
                $db->table('peminjaman_detail')->insert([
                    'id_user'         => user()->id,
                    'peminjaman_id'   => $peminjaman_id,
                    'inventaris_id'   => $kode_barang,
                    'ruangan_id'      => $ruangan_id,
                    'jumlah'          => 1,
                    'jumlah_kembali'  => 0,
                    'kondisi_kembali' => '',
                    'detail'          => "peminjaman dari ruangan " . $inventaris['ruangan_id'] . " ke " . $db->table('ruangan')->where('id', $ruangan_id)->get()->getRow()->nama_ruangan,
                ]);
                // Update status inventaris ke "dipinjam"
                $db->table('inventaris')->where('id', $kode_barang)->where('ruangan_id', $ruangan_id)->update([
                    'status' => 'dipinjam'
                ]);
            }
        }

        // Commit transaksi
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan peminjaman');
        }

        return redirect()->to('/admin/peminjaman')
            ->with('success', 'Peminjaman berhasil disimpan!');
    }

    public function savePeminjaman()
    {
        $db = db_connect();

        // Ambil input dari form
        $barangArr       = $this->request->getPost('barang'); // array: barang[0][kode], barang[0][ruangan_id], barang[0][jumlah]
        $catatan         = $this->request->getPost('catatan');
        $ruanganTujuanId = $this->request->getPost('ruangan_id'); // ruangan tujuan pinjam
        $ruanganSebelum  = isset($barangArr[0]['ruangan_id']) ? $barangArr[0]['ruangan_id'] : null;

        if (empty($barangArr) || !is_array($barangArr)) {
            return redirect()->back()->with('error', 'Barang belum dipilih');
        }

        $db->transStart();


        $headerData = [
            'kode_transaksi'          => 'PINJAM-' . date('YmdHis'),
            'tanggal_permintaan'      => date('Y-m-d H:i:s'),
            'tanggal_pinjam'          => date('Y-m-d'),
            'tanggal_kembali_rencana' => date('Y-m-d', strtotime('+3 days')),
            'tanggal_kembali_real'    => null,
            'id_user'                 => user()->id,
            'approved_by'             => null,
            'ruangan_id_pinjam'       => $ruanganTujuanId,
            'ruangan_id_sebelum'      => $ruanganSebelum,
            'status'                  => 'pengajuan', // <--- default
            'catatan'                 => $catatan,
        ];
        $db->table('peminjaman_header')->insert($headerData);
        $peminjaman_id = $db->insertID();

        // 2️⃣ Insert detail peminjaman (tanpa update stok)
        foreach ($barangArr as $barang) {
            $kode_barang = $barang['kode'];
            $ruangan_id  = $barang['ruangan_id'];
            $jumlah      = isset($barang['jumlah']) ? max(1, intval($barang['jumlah'])) : 1;

            $inventaris = $db->table('inventaris')
                ->where('id', $kode_barang)
                ->get()
                ->getRowArray();

            if (!$inventaris) {
                $db->transRollback();
                return redirect()->back()->with('error', "Barang dengan kode $kode_barang tidak ditemukan");
            }

            // Insert ke detail (tanpa update stok/mutasi)
            $db->table('peminjaman_detail')->insert([
                'id_user'         => user()->id,
                'peminjaman_id'   => $peminjaman_id,
                'inventaris_id'   => $kode_barang,
                'ruangan_id'      => $ruangan_id,
                'jumlah'          => $jumlah,
                'jumlah_kembali'  => 0,
                'kondisi_kembali' => '',
                'detail'          => "Peminjaman dari ruangan " . ($inventaris['ruangan_id'] ?? '-') . " ke " . $db->table('ruangan')->where('id', $ruangan_id)->get()->getRow()->nama_ruangan,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan peminjaman');
        }

        return redirect()->to('/admin/peminjaman')
            ->with('success', 'Pengajuan peminjaman berhasil disimpan!');
    }


    public function approvePeminjaman($id)
    {
        $db = db_connect();
        $header = $db->table('peminjaman_header')->where('id', $id)->get()->getRowArray();

        if (!$header) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }
        if ($header['status'] != 'pengajuan') {
            return redirect()->back()->with('error', 'Status peminjaman tidak bisa di-approve');
        }

        $details = $db->table('peminjaman_detail')->where('peminjaman_id', $id)->get()->getResultArray();

        $db->transStart();

        foreach ($details as $det) {
            $inv = $db->table('inventaris')->where('id', $det['inventaris_id'])->get()->getRowArray();
            $stok = intval($inv['stok']);

            if ($stok < $det['jumlah']) {
                $db->transRollback();
                return redirect()->back()->with('error', "Stok barang " . $inv['id'] . " tidak cukup (tersisa $stok)");
            }

            // Update stok inventaris
            $db->table('inventaris')
                ->where('id', $det['inventaris_id'])
                ->set('stok', 'stok - ' . $det['jumlah'], false)
                ->update();

            // Mutasi transaksi_barang
            $db->table('transaksi_barang')->insert([
                'kode_barang'        => $det['inventaris_id'],
                'id_master_barang'   => $inv['id_master_barang'] ?? null,
                'tanggal_transaksi'  => date('Y-m-d H:i:s'),
                'jenis_transaksi'    => 'PINJAM',
                'informasi_tambahan' => 'Approve peminjaman oleh user ' . user()->id,
                'jumlah_perubahan'   => -$det['jumlah'],
                'user_id'            => user()->id,
            ]);
        }

        // Update status header jadi approved
        $db->table('peminjaman_header')->where('id', $id)->update([
            'status'      => 'approved',
            'approved_by' => user()->id,
            'tanggal_approved' => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal approve peminjaman');
        }

        return redirect()->to('/admin/peminjaman')->with('success', 'Peminjaman berhasil di-approve!');
    }


    public function kembalikanPeminjaman($id)
    {
        $db = db_connect();
        $header = $db->table('peminjaman_header')->where('id', $id)->get()->getRowArray();

        if (!$header) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }
        if ($header['status'] != 'approved') {
            return redirect()->back()->with('error', 'Status peminjaman tidak bisa dikembalikan');
        }

        $details = $db->table('peminjaman_detail')->where('peminjaman_id', $id)->get()->getResultArray();

        $db->transStart();

        foreach ($details as $det) {
            $jumlah_kembali = $det['jumlah']; // atau ambil dari input form kalau pengembalian parsial
            $inv = $db->table('inventaris')->where('id', $det['inventaris_id'])->get()->getRowArray();

            // Update stok inventaris (tambahkan kembali)
            $db->table('inventaris')
                ->where('id', $det['inventaris_id'])
                ->set('stok', 'stok + ' . $jumlah_kembali, false)
                ->update();

            // Mutasi masuk transaksi_barang
            $db->table('transaksi_barang')->insert([
                'kode_barang'        => $det['inventaris_id'],
                'id_master_barang'   => $inv['id_master_barang'] ?? null,
                'tanggal_transaksi'  => date('Y-m-d H:i:s'),
                'jenis_transaksi'    => 'KEMBALI',
                'informasi_tambahan' => 'Pengembalian diverifikasi oleh user ' . user()->id,
                'jumlah_perubahan'   => $jumlah_kembali,
                'user_id'            => user()->id, // user yang menerima barang kembali
            ]);

            // Update di peminjaman_detail
            $db->table('peminjaman_detail')->where('id', $det['id'])->update([
                'jumlah_kembali' => $jumlah_kembali,
                'kondisi_kembali' => 'Baik', // atau dari inputan form
            ]);
        }

        // Update status header jadi dikembalikan
        $db->table('peminjaman_header')->where('id', $id)->update([
            'status'                  => 'dikembalikan',
            'tanggal_kembali_real'    => date('Y-m-d H:i:s'),
            'user_penerima_kembali'   => user()->id, // tambahin di model kalau perlu
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal proses pengembalian');
        }

        return redirect()->to('/admin/peminjaman')->with('success', 'Peminjaman berhasil dikembalikan!');
    }


    public function merk()
    {
        $data = [
            'title' => 'merk barang',
            'merk'  => $this->MerkBarangModel->findAll(),
        ];
        return view('Admin/Merk/Index', $data);
    }

    public function tambah_merk()
    {
        $data = [
            'title'      => 'Tambah merk',
            'validation' => $this->validation,
        ];
        return view('Admin/merk/Tambah_merk', $data);
    }

    public function simpanMerk()
    {
        if (! $this->validate([

            'nama_merk' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'nama merk harus diisi',
                    // 'is_unique' => '',
                ],
            ],
        ])) {
            return redirect()->to('/admin/tambah_merk')->withInput();
        }
        $data = [
            'nama_merk' => $this->request->getPost('nama_merk'),
        ];
        // dd($data);
        $this->MerkBarangModel->insert($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin/merk');
    }

    public function merk_edit($id)
    {
        $data = [
            'title'      => 'Ubah Merk',
            'validation' => $this->validation,
            'merk'       => $this->MerkBarangModel->find($id),
        ];
        return view('Admin/Merk/Edit_merk', $data);
    }
    public function updateMerk()
    {
        $id   = $this->request->getPost('id');
        $data = [
            'nama_merk' => $this->request->getPost('nama_merk'),
        ];
        $this->MerkBarangModel->update($id, $data);
        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/admin/merk');
    }
    public function merk_delete($id)
    {
        $this->MerkBarangModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/admin/merk');
    }

    public function kategori()
    {
        $data = [
            'title'    => 'Kategori barang',
            'kategori' => $this->KategoriBarangModel->findAll(),
        ];
        return view('Admin/Kategori/Index', $data);
    }

    public function tambah_kategori()
    {
        $data = [
            'title'      => 'Tambah Kategori',
            'validation' => $this->validation,
        ];
        return view('Admin/kategori/Tambah_kategori', $data);
    }

    public function simpanKategori()
    {
        if (! $this->validate([

            'nama_kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'nama kategori harus diisi',
                    // 'is_unique' => '',
                ],
            ],
        ])) {
            return redirect()->to('/admin/tambah_kategori')->withInput();
        }
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ];
        // dd($data);
        $this->KategoriBarangModel->insert($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/admin/kategori');
    }

    public function kategori_edit($id)
    {
        $data = [
            'title'      => 'Ubah kategori',
            'validation' => $this->validation,
            'kategori'   => $this->KategoriBarangModel->find($id),
        ];
        return view('Admin/Kategori/Edit_kategori', $data);
    }
    public function updateKategori()
    {
        $id   = $this->request->getPost('id');
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ];
        $this->KategoriBarangModel->update($id, $data);
        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/admin/kategori');
    }
    public function kategori_delete($id)
    {
        $this->KategoriBarangModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/admin/kategori');
    }

    public function KategoriMerk()
    {
        $data = [
            'title'        => 'kategori Merk',
            'KategoriMerk' => $this->MerkKategoriBarangModel->fetchAll(),
        ];

        return view('Admin/Kategori-merk/index', $data);
    }

    // Form tambah MerkKategoriBarang
    public function tambahMerkKategori()
    {
        $data = [
            'title'      => 'Tambah Merk pada Kategori',
            'kategori'   => $this->KategoriBarangModel->findAll(),
            'merk'       => $this->MerkBarangModel->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('Admin/Kategori-merk/tambah', $data);
    }

    // Simpan relasi baru
    public function SaveKategorimerk()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'kategori_id' => 'required',
            'merk_id'     => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('PesanGagal', 'Harap pilih kategori dan merk.');
        }

        $kategori_id = $this->request->getPost('kategori_id');
        $merk_id     = $this->request->getPost('merk_id');

        // Cek duplikasi
        $exists = $this->MerkKategoriBarangModel->checkExists($kategori_id, $merk_id);
        if ($exists) {
            return redirect()->back()->with('PesanGagal', 'Relasi kategori–merk sudah ada.');
        }

        $this->MerkKategoriBarangModel->insert([
            'kategori_id' => $kategori_id,
            'merk_id'     => $merk_id,
        ]);

        return redirect()->to('/admin/KategoriMerk')->with('PesanBerhasil', 'Relasi berhasil ditambahkan.');
    }

    public function kategoriMerk_edit($id)
    {
        $relasi = $this->MerkKategoriBarangModel->find($id);
        if (! $relasi) {
            return redirect()->to('/Admin/KategoriMerk')->with('PesanGagal', 'Data relasi tidak ditemukan.');
        }

        $data = [
            'title'    => 'Edit Relasi Kategori - Merk',
            'relasi'   => $relasi,
            'kategori' => $this->KategoriBarangModel->findAll(),
            'merk'     => $this->MerkBarangModel->findAll(),
        ];
        return view('Admin/Kategori-merk/Edit', $data);
    }

    // 🔹 Update relasi
    public function KategoriMerk_update($id)
    {
        $kategori_id = $this->request->getPost('kategori_id');
        $merk_id     = $this->request->getPost('merk_id');

        // Cek duplikasi
        $exists = $this->MerkKategoriBarangModel
            ->where('kategori_id', $kategori_id)
            ->where('merk_id', $merk_id)
            ->where('id !=', $id)
            ->first();

        if ($exists) {
            return redirect()->back()->with('PesanGagal', 'Relasi sudah ada.');
        }

        $this->MerkKategoriBarangModel->update($id, [
            'kategori_id' => $kategori_id,
            'merk_id'     => $merk_id,
        ]);

        return redirect()->to('/Admin/KategoriMerk')->with('PesanBerhasil', 'Relasi berhasil diperbarui.');
    }

    // 🔹 Delete relasi
    public function KategoriMerk_delete($id)
    {
        $relasi = $this->MerkKategoriBarangModel->find($id);
        if (! $relasi) {
            return redirect()->to('/Admin/KategoriMerk')->with('PesanGagal', 'Data tidak ditemukan.');
        }

        $this->MerkKategoriBarangModel->delete($id);

        return redirect()->to('/Admin/KategoriMerk')->with('PesanBerhasil', 'Relasi berhasil dihapus.');
    }

    // peminjaman
    public function peminjaman_masuk()
    {
        $peminjaman = $this->PeminjamanDetailModel->getPeminjamanMasuk();
        $data       = [
            'peminjaman' => $peminjaman,
            'title'      => 'Daftar Peminjaman Masuk',
        ];
        return view('Admin/Peminjaman/Index', $data);
    }

    public function peminjaman_proses()
    {
        $peminjaman = $this->PeminjamanDetailModel->getPeminjamanProses();
        $data       = [
            'peminjaman' => $peminjaman,
            'title'      => 'Daftar Peminjaman Diproses',
        ];
        return view('Admin/Peminjaman/Index', $data);
    }

    public function peminjaman_selesai()
    {
        $peminjaman = $this->PeminjamanDetailModel->getPeminjamanSelesai();
        $data       = [
            'peminjaman' => $peminjaman,
            'title'      => 'Daftar Peminjaman Selesai',
        ];
        return view('Admin/Peminjaman/Index', $data);
    }

    public function prosesPeminjaman($id)
    {
        $this->PeminjamanDetailModel->update($id, [
            'tanggal_diproses' => date("Y-m-d H:i:s"),
            'status'           => 'diproses',
        ]);
        session()->setFlashdata('msg', 'Status peminjaman berhasil diubah menjadi Diproses');
        return redirect()->to('Admin/detailpinjam/' . $id);
    }

    public function terimaPeminjaman($id)
    {
        $this->PeminjamanDetailModel->update($id, [
            'tanggal_selesai' => date("Y-m-d H:i:s"),
            'status'          => 'selesai',
            'status_akhir'    => 'diterima',
        ]);
        session()->setFlashdata('msg', 'Status peminjaman berhasil Diubah menjadi Selesai/Diterima');
        return redirect()->to('Admin/detailpinjam/' . $id);
    }

    // public function tolakPeminjaman($id)
    // {
    //     $rules = [
    //         'kategori'         => [
    //             'rules'  => 'required',
    //             'errors' => [
    //                 'required' => 'Kategori wajib diisi.',
    //             ],
    //         ],
    //         'alasan_penolakan' => [
    //             'rules'  => 'required',
    //             'errors' => [
    //                 'required' => 'Alasan penolakan wajib diisi.',
    //             ],
    //         ],
    //     ];

    //     if (! $this->validate($rules)) {
    //         $validation = \Config\Services::validation();
    //         return redirect()->to('/Admin/detailpinjam/' . $id)->withInput('validation', $validation);
    //     }
    //     $this->PeminjamanDetailModel->update($id, [
    //         'tanggal_selesai' => date("Y-m-d H:i:s"),
    //         'status'          => 'selesai',
    //         'status_akhir'    => 'ditolak',
    //     ]);
    //     $data = [
    //         'id_peminjaman_detail' => $id,
    //         'kategori'             => $this->request->getPost('kategori'),
    //         'alasan_penolakan'     => $this->request->getPost('alasan_penolakan'),
    //     ];
    //     $this->BalasanPeminjamanModel->save($data);
    //     session()->setFlashdata('msg', 'Status peminjaman berhasil Diubah');
    //     return redirect()->to('Admin/detailpinjam/' . $id);
    // }

    public function detailpinjam($id)
    {
        $barangList = $this->BarangModel->findAll();
        $data       = $this->PeminjamanDetailModel->getDetailPeminjaman($id);

        $balasan = $this->db->table('balasan_peminjaman')
            ->select('*')
            ->where('id_peminjaman_detail', $id)
            ->get()
            ->getRow();

        $ex = [
            'detail'     => $data,
            'title'      => 'Detail Peminjaman',
            'balasan'    => $balasan,
            'barangList' => $barangList,
            'validation' => \Config\Services::validation(),
        ];

        return view('Admin/Peminjaman/Detail_peminjaman', $ex);
    }
}
