<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use CodeIgniter\HTTP\ResponseInterface;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function createKategori()
    {
        $data = $this->request->getJSON(true);
        if (!isset($data['nama_kategori']) || empty($data['nama_kategori'])) {
            return $this->response->setJSON([
                'status' => 400,
                'message' => 'Nama kategori wajib diisi'
            ]);
        }

        $insert = $this->kategoriModel->insert([
            'nama_kategori' => $data['nama_kategori']
        ]);

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Kategori berhasil ditambahkan',
            'insert_id' => $insert
        ]);
    }

    public function getAllKategori()
    {
        $data = $this->kategoriModel->select('kategori.*')
        ->orderBy('kategori.id_kategori', 'DESC')
        ->findAll();

        if (empty($data)) {
            return $this->response->setJSON([
                'status' => 200,
                'message' => 'Kategori Tidak Ada',
                'data' => []
            ]);
        }
        return $this->response->setJSON([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function getByIdKategori($id)
    {
        $data = $this->kategoriModel->find($id);

        if (!$data) {
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Kategori Tidak Ditemukan'
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

        //cek data kosong
        if (!isset($data['nama_kategori']) || empty($data['nama_kategori'])) {
            return $this->response->setJSON([
                'status' => 400,
                'message' => 'Nama Kategori wajib diisi'
            ]);
        }

        //cek data sudah ada
        $this->kategoriModel->update($id, [
            'nama_kategori' => $data['nama_kategori']
        ]);

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Kategori berhasil diupdate'
        ]);
    }

    public function delete($id)
    {
        //cek data ada apa tidak
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            return $this->response->setJSON([
                'status' => 404,
                'message' => 'Kategori Tidak ditemukan'
            ]);
        }

        //hapus data
        $this->kategoriModel->delete($id);

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}
