<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;

class Barang extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function createBarang()
    {
        $data = $this->request->getJSON(true);

        if (
            empty($data['nama_barang']) ||
            empty($data['kode_barang']) ||
            empty($data['satuan']) ||
            empty($data['id_kategori'])
        ) {
            return $this->response->setJSON([
                'status' => 400,
                'message' => 'semua field wajib diisi'
            ]);
        }

        if (!$this->barangModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $this->barangModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => 201,
            'message' => 'barang berhasil ditambahkan'
        ]);
    }

    public function getAllBarang()
    {
        $data = $this->barangModel->select('barang.*, kategori.nama_kategori')
        ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
        ->orderBy('barang.id_barang', 'DESC')
        ->findAll();   

        if (empty($data)) {
            return $this->response->setJSON([
                'status' => 200,
                'message' => 'Barang Belum Ada',
                'data' => []
            ]);
        }

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Berhasil Menampilkan Barang',
            'data' => $data
        ]);
    }

    public function getByIdBarang($id)
    {
        $data = $this->barangModel->select('barang.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->where('id_barang', $id)
            ->first();
        
        if (!$data) {
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Data Tidak Ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getJSON(true);

        $barang = $this->barangModel->find($id);
        if (!$barang) {
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        if (!$this->barangModel->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 500,
                'error' => $this->barangModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Barang berhasil diupdate'
        ]);

    }

    public function delete($id)
    {
        $barang = $this->barangModel->find($id);
        if (!$barang) {
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $this->barangModel->delete($id);

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Barang Berhasil diHapus'
        ]);
    }
}
