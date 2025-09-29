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

/**
 * @property Home_model $home_model
 * @property Ciqrcode $ciqrcode
 * @property CI_Input $input
 */
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
        $this->ciqrcode                = new \App\Libraries\Ciqrcode();
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
            return redirect()->to(base_url('user/tentang/' . $id));
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
        $role == '1' ? $role_echo = 'user' : $role_echo = 'User';



        $data = $this->db->table('peminjaman_header');
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

            // 'user' => $query,
            // 'validation' => $this->validation,
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
            ->select('peminjaman_header.*, users.username as peminjam, users.fullname as nama_lengkap, r.nama_ruangan as lokasi_pinjam')
            ->join('users', 'users.id = peminjaman_header.id_user', 'left')
            ->join('ruangan r', 'r.id = peminjaman_header.ruangan_id_pinjam', 'left')
            ->orderBy('peminjaman_header.tanggal_pinjam', 'desc')
            ->where('peminjaman_header.id_user', user()->id);


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
        return view('user/Peminjaman/Index', $data);
    }

    public function tambahPeminjaman()
    {
        $status  = $this->request->getGet('status') ?? 'all';
        $users   = $this->Profil->findAll();
        $barangs = $this->InventarisModel
            ->join('master_barang', 'master_barang.kode_brg = inventaris.id_master_barang', 'left')
            ->where('inventaris.stok >', 0)
            ->findAll();

        $ruangan    = $this->RuanganModel->findAll();
        $mapRuangan = [];
        foreach ($ruangan as $r) {
            $mapRuangan[$r['id']] = $r['nama_ruangan'];
        }
        $data = [
            'users'      => $users,
            'barangs'    => $barangs,
            'title'      => 'Tambah Peminjaman',
            'ruangan'    => $ruangan,
            'mapRuangan' => $mapRuangan,
            'status'     => $status,
        ];

        // dd($data);
        return view('user/Peminjaman/Tambah', $data);
    }

    public function savePeminjaman()
    {
        $db = db_connect();

        // Ambil input dari form
        $barangArr       = $this->request->getPost('barang'); // array: barang[0][kode], barang[0][ruangan_id], barang[0][jumlah]
        $catatan         = $this->request->getPost('catatan');
        $ruanganTujuanId = $this->request->getPost('ruangan_id'); // ruangan tujuan pinjam
        $ruanganSebelum  = isset($barangArr[0]['ruangan_id']) ? $barangArr[0]['ruangan_id'] : null;

        if (empty($barangArr) || ! is_array($barangArr)) {
            return redirect()->back()->with('error', 'Barang belum dipilih');
        }

        $db->transStart();

        $headerData = [
            'kode_transaksi'          => 'PINJAM-' . date('YmdHis'),
            'tanggal_pinjam'          => null, // masih pending
            'tanggal_kembali_rencana' => null, // isi nanti saat approve
            'tanggal_kembali_real'    => null,
            'id_user'                 => user()->id,
            'approved_by'             => null,
            'ruangan_id_pinjam'       => $ruanganTujuanId,
            'ruangan_id_sebelum'      => $ruanganSebelum,
            'tanggal_pinjam'          => date('Y-m-d'),
            'tanggal_kembali_rencana' => date('Y-m-d'),
            'status'                  => 'pengajuan',
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

            if (! $inventaris) {
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

        return redirect()->to('/user/peminjaman')
            ->with('success', 'Pengajuan peminjaman berhasil disimpan!');
    }


    public function kembalikanPeminjaman($id)
    {
        $db     = db_connect();
        $header = $db->table('peminjaman_header')->where('peminjaman_id', $id)->get()->getRowArray();

        if (! $header) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }

        // Hanya boleh kembalikan jika status masih dipinjam
        if ($header['status'] != 'dipinjam') {
            return redirect()->back()->with('error', 'Status peminjaman tidak bisa dikembalikan');
        }

        // Update header jadi menunggu verifikasi
        $db->table('peminjaman_header')->where('peminjaman_id', $id)->update([
            'status'               => 'menunggu_kembali',
            'tanggal_kembali_real' => date('Y-m-d H:i:s'), // user sudah mengembalikan secara fisik
        ]);

        return redirect()->to('/user/peminjaman')->with('success', 'Barang sudah ditandai untuk dikembalikan, menunggu verifikasi admin.');
    }


    public function detailPeminjaman($id)
    {
        $db = db_connect();

        $userid = user()->id;
        $role = $this->db->table('auth_groups_users')->where('user_id', $userid)->get()->getRow();
        $role == '1' ? $role_echo = 'user' : $role_echo = 'User';
        // --- Ambil data header ---
        $header = $db->table('peminjaman_header ph')
            ->select('ph.*, 
              u.username as username_peminjam, 
              u.fullname as fullname_peminjam, 
              up.username as username_penerima_kembali, 
              up.fullname as fullname_penerima_kembali, 
              r1.nama_ruangan as ruangan_pinjam, 
              r2.nama_ruangan as ruangan_sebelum')
            ->join('users u', 'u.id = ph.id_user', 'left')                     // user peminjam
            ->join('users up', 'up.id = ph.user_penerima_kembali', 'left')     // user penerima kembali
            ->join('ruangan r1', 'r1.id = ph.ruangan_id_pinjam', 'left')
            ->join('ruangan r2', 'r2.id = ph.ruangan_id_sebelum', 'left')
            ->where('ph.peminjaman_id', $id)
            ->get()
            ->getRowArray();

        if (! $header) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan!');
        }

        // --- Ambil data detail barang yang dipinjam ---
        $details = $db->table('peminjaman_detail')
            ->select('peminjaman_detail.*, i.*, m.*, r.*')
            ->join('inventaris i', 'i.id = peminjaman_detail.inventaris_id', 'left')
            ->join('master_barang m', 'm.kode_brg = i.id_master_barang', 'left')
            ->join('ruangan r', 'r.id = peminjaman_detail.ruangan_id', 'left')
            ->where('peminjaman_detail.peminjaman_id', $id)
            ->get()
            ->getResultArray();


        // --- (Optional) Mutasi pengembalian barang, untuk riwayat audit ---
        $mutasi = [];
        if (! empty($details)) {
            $inventarisIds = array_column($details, 'inventaris_id');
            $mutasi        = $db->table('transaksi_barang')
                ->whereIn('kode_barang', $inventarisIds)
                ->where('jenis_transaksi', 'KEMBALI')
                ->orderBy('tanggal_transaksi', 'desc')
                ->get()
                ->getResultArray();
        }

        $data = [
            'header'  => $header,
            'details' => $details,
            'mutasi'  => $mutasi,
            'role' => $role_echo,
            'title'   => 'Detail Peminjaman Barang',
        ];

        // dd($data);
        return view('user/Peminjaman/Detail', $data);
    }
}
