<?php

namespace App\Controllers;

use App\Models\Pengaduan;
use App\Models\bukti;
use App\Models\profil;
use CodeIgniter\Database\Query;
use Myth\Auth\Entities\passwd;
use Myth\Auth\Models\UserModel;

class User extends BaseController
{
    protected $db, $builder;
    public function __construct()
    {

        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->pengaduan = new pengaduan();
        $this->bukti = new bukti();
        $this->profil = new profil();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {

        $userlogin = user()->id;

        $data = $this->db->table('pengaduan');
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
            'title' => 'Home'
        ];
        // dd($data);
        return view('user/profil/home', $data);
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
    public function pengaduan()
    {

        // $builder    = $this->db->table('pengaduan');
        // $builder->orderBy('id', 'ASC');
        // $query      = $builder->get()->getResult();
        // $data['pengaduan'] = $query;
        $this->builder = $this->db->table('pengaduan');
        $this->builder->select('*');
        $this->builder->where('id_user', user()->id);
        $this->query = $this->builder->get();
        $data['pengaduan'] = $this->query->getResultArray();
        // dd(  $data['pengaduan']);
        $data['title'] = 'Pengaduan';
        return view('user/pengaduan/index', $data);
    }

    public function tambah()
    {
        $data = [
            'validation' => $this->validation,
            'title' => 'Tambah Pengaduan'
        ];

        return view('user/pengaduan/tambah_pengaduan', $data);
    }
    public function simpanPengaduan()
    {
        $rules = [
            'judul_pengaduan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Perihal pengaduan wajib diisi.'
                ]
            ],
            'isi_pengaduan' => [
                'rules' => 'required|min_length[30]',
                'errors' => [
                    'required' => 'Isi pengaduan wajib diisi.',
                    'min_length' => 'Minimal 30 karakter.'
                ]
            ],
            'images' => [
                'rules' => 'uploaded[images.0]|max_size[images,1024]|is_image[images]|mime_in[images,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Satu file wajib ada.',
                    'max_size' => 'Anda mengupload file yang melebihi ukuran maksimal.',
                    'is_image' => 'Anda mengupload file yang bukan gambar.',
                    'mime_in' => 'Anda mengupload file yang bukan gambar.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return redirect()->to('/user/tambah')->withInput('validation', $validation);
        }

        $images = $this->request->getFileMultiple('images');
        $jumlahFile = count($images);
        if ($jumlahFile > 3) { // jika jumlah file melebihi aturan (3)
            session()->setFlashdata('err-files', '<span class="text-danger">Jumlah file yang anda upload melebihi aturan.</span>');
            return redirect()->to('/user/tambah');
        }

        if ($this->request->getPost('nama_pengadu') == 'anonym') {
            $nama_pengadu = $this->request->getPost('nama_pengadu');
        } else {
            $nama_pengadu = $this->request->getPost('pengadu');
        }
        $date = date("Y/m/d h:i:s");
        $dataPengaduan = [
            'id_user' => user()->id,
            'perihal' => $this->request->getPost('judul_pengaduan'),
            'detail' => $this->request->getPost('isi_pengaduan'),
            'nama_pengadu' => $nama_pengadu,
            'tanggal_pengaduan' => $date,
            'status' => 'belum diproses',

        ];
        $this->pengaduan->save($dataPengaduan);

        foreach ($images as $i => $img) {
            if ($img->isValid() && !$img->hasMoved()) {
                $files[$i] = 'bukti' . $i . '-' . user()->id . '.' . $img->guessExtension();
            }
        }
        $pengaduan_id = $this->pengaduan->insertID(); // last insert id
        $img_dua = (array_key_exists(1, $files) ? $files[1] : 'null');
        $img_tiga = (array_key_exists(2, $files) ? $files[2] : 'null');
        foreach ($images as $i => $img) {
            if ($img->isValid() && !$img->hasMoved()) {
                $files[$i] = 'bukti' . $i . '-' . $pengaduan_id . user()->username . '.' . $img->guessExtension();
            }
        }
        $this->bukti->save([
            'pengaduan_id' => $pengaduan_id,
            'img_satu' => $files[0],
            'img_dua' => $img_dua,
            'img_tiga' => $img_tiga,
        ]);

        foreach ($images as $i => $img) {
            if ($img->isValid() && !$img->hasMoved()) {
                $img->move('uploads', $files[$i]);
            }
        }
        session()->setFlashdata('msg', 'Pengaduan berhasil ditambah, silahkan menunggu untuk proses approval.');
        return redirect()->to('user/pengaduan/tambah_pengaduan');
    }



    public function detail($id)
    {
        $data = $this->db->table('pengaduan');
        $data->select('*');
        $data->where('id', $id);
        $query = $data->get();

        $d = $this->db->table('balasan');
        $d->select('*');
        $d->where('id_pengaduan', $id);
        $balasan = $d->get()->getRow();

        $bukti = $this->db->table('tbl_bukti');
        $bukti->select('*');
        $bukti->where('pengaduan_id', $id);
        $query1 = $bukti->get()->getRowArray();
        // dd($query1);
        $ex = [
            'bukti' => $query1,
            'detail' => $hasil = $query->getRow(),
            'title' => 'Detail Pengaduan',
            'balasan' => $balasan

        ];


        return view('user/pengaduan/detail', $ex);
    }
    public function ubah($id)
    {

        $data = $this->db->table('pengaduan');
        $data->select('*');
        $data->where('id', $id);
        $query = $data->get();

        $bukti = $this->db->table('tbl_bukti');
        $bukti->select('*');
        $bukti->where('pengaduan_id', $id);
        $query1 = $bukti->get()->getRowArray();
        $data = [
            'bukti' => $query1,
            'data' => $hasil = $query->getRowArray(),
            'validation' => $this->validation,
            'title' => 'Ubah Pengaduan'

        ];




        return view('user/pengaduan/ubah_pengaduan', $data);
    }

    public function ubahPengaduan($id)
    {
        $data['validation'] = \Config\Services::connect();
        $rules = [
            'judul_pengaduan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Perihal pengaduan wajib diisi.'
                ]
            ],
            'isi_pengaduan' => [
                'rules' => 'required|min_length[30]',
                'errors' => [
                    'required' => 'Isi pengaduan wajib diisi.',
                    'min_length' => 'Minimal 30 karakter.'
                ]
            ],
            'images' => [
                'rules' => 'max_size[images,1024]|is_image[images]|mime_in[images,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => 'Satu file wajib ada.',
                    'max_size' => 'Anda mengupload file yang melebihi ukuran maksimal.',
                    'is_image' => 'Anda mengupload file yang bukan gambar.',
                    'mime_in' => 'Anda mengupload file yang bukan gambar.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return redirect()->to('/user/ubah/' . $id)->withInput('validation', $validation);
        }

        $images = $this->request->getFileMultiple('images');
        $jumlahFile = count($images);
        if ($jumlahFile > 3) { // jika jumlah file melebihi aturan (3)
            session()->setFlashdata('err-files', '<span class="text-danger">Jumlah file yang anda upload melebihi aturan.</span>');
            return redirect()->to('/user/ubah' . $id);
        }

        if ($this->request->getPost('nama_pengadu') == 'anonym') {
            $nama_pengadu = $this->request->getPost('nama_pengadu');
        } else {
            $nama_pengadu = $this->request->getPost('pengadu');
        }
        $date = date("Y/m/d h:i:s");
        // $dataPengaduan = [
        //     'id_user' => user()->id,
        //     'perihal' => $this->request->getPost(' '),
        //     'detail' => $this->request->getPost('isi_pengaduan'),
        //     'nama_pengadu' => $nama_pengadu,
        //     'tanggal_pengaduan' => $date,
        //     'status' => 'belum diproses',

        // ];
        $this->pengaduan->update($id, [
            'id_user' => user()->id,
            'perihal' => $this->request->getPost('judul_pengaduan'),
            'detail' => $this->request->getPost('isi_pengaduan'),
            'nama_pengadu' => $nama_pengadu,
            'tanggal_pengaduan' => $date,
            'status' => 'belum diproses',

        ]);
        if ($images[0]->getError() !== 4) {
            foreach ($images as $i => $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $files[$i] = 'bukti' . $i . '-' . user()->id . '.' . $img->guessExtension();
                }
            }

            // get data bukti
            $bukti = $this->bukti->getBukti($id);

            // hapus file lama
            unlink('uploads/' . $bukti['img_satu']);
            if ($bukti['img_dua'] != null) {
                unlink('uploads/' . $bukti['img_dua']);
            }
            if ($bukti['img_tiga'] != null) {
                unlink('uploads/' . $bukti['img_tiga']);
            }

            // update tbl_bukti
            $img_dua = (array_key_exists(1, $files) ? $files[1] : 'null');
            $img_tiga = (array_key_exists(2, $files) ? $files[2] : 'null');

            $this->bukti->save([
                'id' => $this->request->getPost('bukti_id'),
                'img_satu' => $files[0],
                'img_dua' => $img_dua,
                'img_tiga' => $img_tiga,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            // move file baru
            foreach ($images as $i => $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $img->move('uploads', $files[$i]);
                }
            }
        }

        session()->setFlashdata('msg', 'Pengaduan berhasil diubah.');
        return redirect()->to('user/pengaduan');
    }

    public function print()
    {
        $data = [
            'pengaduan' => $this->pengaduan->getAll(),
            'title' => 'Cetak Data'
        ];

        $dompdf = new \Dompdf\Dompdf();
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);

        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml(view('user/pengaduan/print', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ini_set('max_execution_time', 0);
        $dompdf->stream('Data.pdf', array("Attachment" => false));
    }
    public function ekspor($id)
    {
        // $aduan = $this->pengaduan->where(['id' => $id])->first();
        // $id = $id;
        // $data['detail']   = $aduan;
        $data['title']   = 'cetak';
        $data['detail'] = $this->pengaduan->where(['id' => $id])->first();



        //Cetak dengan dompdf
        $dompdf = new \Dompdf\Dompdf();
        ini_set('max_execution_time', 0);
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);

        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml(view('user/pengaduan/cetak', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Detail Pengaduan.pdf', array("Attachment" => false));
    }
}
