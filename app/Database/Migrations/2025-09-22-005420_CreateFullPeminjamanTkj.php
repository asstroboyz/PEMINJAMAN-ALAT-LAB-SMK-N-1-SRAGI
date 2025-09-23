<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFullPeminjamanTkj extends Migration
{
    public function up()
    {
        // 1. kategori_barang
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'nama_kategori' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori_barang', true);

        // 2. satuan
        $this->forge->addField([
            'satuan_id'   => ['type' => 'INT', 'auto_increment' => true],
            'nama_satuan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('satuan_id', true);
        $this->forge->createTable('satuan', true);

        // 3. ruangan
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'nama_ruangan' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'keterangan'   => ['type' => 'TEXT', 'null' => true],
            'is_active'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ruangan', true);

        // 4. users
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'email'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'username'          => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'fullname'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'foto'              => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'profil.svg'],
            'password_hash'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'reset_hash'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'reset_at'          => ['type' => 'DATETIME', 'null' => true],
            'reset_expires'     => ['type' => 'DATETIME', 'null' => true],
            'activate_hash'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status_message'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'active'            => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'force_pass_reset'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users', true);

        // 5. master_barang
        $this->forge->addField([
            'kode_brg'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'nama_brg'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'merk'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'kategori_id' => ['type' => 'INT', 'null' => true],
            'tipe_serie'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jenis_brg'   => ['type' => 'ENUM', 'constraint' => ['hrd', 'sfw', 'tools'], 'null' => true],
            'spesifikasi' => ['type' => 'TEXT', 'null' => true],
            'foto'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'id_satuan'   => ['type' => 'INT', 'null' => true],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => false],
            'updated_at'  => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('kode_brg', true);
        $this->forge->addForeignKey('kategori_id', 'kategori_barang', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('master_barang', true);

        // 6. inventaris
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'kode_barang'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'id_master_barang'=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'kondisi'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'stok'            => ['type' => 'INT', 'default' => 0],
            'spesifikasi'     => ['type' => 'VARCHAR', 'constraint' => 110, 'null' => false],
            'ruangan_id'      => ['type' => 'INT', 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['tersedia','dipinjam','rusak','hilang'], 'default' => 'tersedia'],
            'qrcode'          => ['type' => 'TEXT', 'null' => false],
            'file'            => ['type' => 'TEXT', 'null' => false],
            'created_at'      => ['type' => 'DATETIME', 'null' => false],
            'updated_at'      => ['type' => 'DATETIME', 'null' => false],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_master_barang', 'master_barang', 'kode_brg', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('inventaris', true);

        // 7. peminjaman_header
        $this->forge->addField([
            'peminjaman_id'          => ['type' => 'INT', 'auto_increment' => true],
            'kode_transaksi'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'tanggal_permintaan'     => ['type' => 'DATE', 'null' => false],
            'tanggal_pinjam'         => ['type' => 'DATETIME', 'null' => false],
            'tanggal_kembali_rencana'=> ['type' => 'DATETIME', 'null' => true],
            'tanggal_kembali_real'   => ['type' => 'DATETIME', 'null' => true],
            'id_user'                => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'approved_by'            => ['type' => 'INT', 'null' => true],
            'ruangan_id_pinjam'      => ['type' => 'INT', 'null' => true],
            'ruangan_id_sebelum'     => ['type' => 'INT', 'null' => true],
            'status'                 => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'catatan'                => ['type' => 'TEXT', 'null' => true],
            'alasan_reject'          => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('peminjaman_id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ruangan_id_pinjam', 'ruangan', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('ruangan_id_sebelum', 'ruangan', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('peminjaman_header', true);

        // 8. peminjaman_detail
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'id_user'         => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'peminjaman_id'   => ['type' => 'INT', 'null' => false],
            'jumlah'          => ['type' => 'INT', 'null' => false],
            'jumlah_kembali'  => ['type' => 'INT', 'default' => 0],
            'kondisi_kembali' => ['type' => 'ENUM', 'constraint' => ['baik','rusak','hilang'], 'default' => 'baik'],
            'detail'          => ['type' => 'TEXT', 'null' => false],
            'inventaris_id'   => ['type' => 'INT', 'null' => true],
            'ruangan_id'      => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('peminjaman_id', 'peminjaman_header', 'peminjaman_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('inventaris_id', 'inventaris', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman_detail', true);

        // 9. transaksi_barang
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'auto_increment' => true],
            'kode_barang'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'id_master_barang'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'tanggal_transaksi'  => ['type' => 'DATETIME', 'null' => true],
            'jenis_transaksi'    => ['type' => 'ENUM', 'constraint' => ['masuk','keluar','rusak','pindah','afkir'], 'null' => true],
            'informasi_tambahan' => ['type' => 'TEXT', 'null' => true],
            'jumlah_perubahan'   => ['type' => 'INT', 'null' => false],
            'user_id'            => ['type' => 'INT', 'null' => true],
            'deleted_at'         => ['type' => 'DATETIME', 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transaksi_barang', true);

        // 10. pengecekan
        $this->forge->addField([
            'pengecekan_id'      => ['type' => 'INT', 'auto_increment' => true],
            'id_inventaris'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'tanggal_pengecekan' => ['type' => 'DATE', 'null' => false],
            'ruangan_id_lama'    => ['type' => 'INT', 'null' => true],
            'keterangan'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
        ]);
        $this->forge->addKey('pengecekan_id', true);
        $this->forge->addForeignKey('ruangan_id_lama', 'ruangan', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('pengecekan', true);

        // 11. auth_groups
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_groups', true);

        // 12. auth_permissions
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_permissions', true);

        // 13. auth_groups_permissions
        $this->forge->addField([
            'group_id'      => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'permission_id' => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
        ]);
        $this->forge->addKey(['group_id', 'permission_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth_groups_permissions', true);

        // 14. auth_groups_users
        $this->forge->addField([
            'group_id' => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'user_id'  => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
        ]);
        $this->forge->addKey(['group_id', 'user_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth_groups_users', true);

        // 15. auth_users_permissions
        $this->forge->addField([
            'user_id'      => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'permission_id'=> ['type' => 'INT', 'unsigned' => true, 'default' => 0],
        ]);
        $this->forge->addKey(['user_id', 'permission_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth_users_permissions', true);

        // 16. auth_activation_attempts
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'user_agent' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'token'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_activation_attempts', true);

        // 17. auth_logins
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'ip_address'=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'user_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'date'      => ['type' => 'DATETIME', 'null' => false],
            'success'   => ['type' => 'TINYINT', 'constraint' => 1, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_logins', true);

        // 18. auth_reset_attempts
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'user_agent' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'token'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_reset_attempts', true);

        // 19. auth_tokens
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'selector'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'hashedValidator'=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'user_id'        => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'expires'        => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth_tokens', true);

        // 20. migrations
        $this->forge->addField([
            'id'       => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'version'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'class'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'group'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'namespace'=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'time'     => ['type' => 'INT', 'null' => false],
            'batch'    => ['type' => 'INT', 'unsigned' => true, 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('migrations', true);
    }

    public function down()
    {
        // Urutan harus dari tabel yang paling "banyak FK" ke paling parent
        $this->forge->dropTable('auth_tokens', true);
        $this->forge->dropTable('auth_reset_attempts', true);
        $this->forge->dropTable('auth_logins', true);
        $this->forge->dropTable('auth_activation_attempts', true);
        $this->forge->dropTable('auth_users_permissions', true);
        $this->forge->dropTable('auth_groups_users', true);
        $this->forge->dropTable('auth_groups_permissions', true);
        $this->forge->dropTable('auth_permissions', true);
        $this->forge->dropTable('auth_groups', true);
        $this->forge->dropTable('peminjaman_detail', true);
        $this->forge->dropTable('peminjaman_header', true);
        $this->forge->dropTable('inventaris', true);
        $this->forge->dropTable('master_barang', true);
        $this->forge->dropTable('kategori_barang', true);
        $this->forge->dropTable('pengecekan', true);
        $this->forge->dropTable('satuan', true);
        $this->forge->dropTable('transaksi_barang', true);
        $this->forge->dropTable('ruangan', true);
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('migrations', true);
    }
}
