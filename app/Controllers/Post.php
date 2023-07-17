<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Post_model;

class Post extends BaseController
{
    public function index()
    {
        $post_model = new Post_model();
        $data = [
            'article'   => $post_model->findAll()
        ];
        return view('post_view', $data);
    }

    public function save()
    {
        $post_model = new Post_model();
        $title = $this->request->getPost('title');
        $contents = $this->request->getPost('contents');

        $post_model->insert([
            'title'     => $title,
            'contents'  => $contents
        ]);

        return redirect()->to(base_url())->with('success', 'Daftar Produk Berhasil Diubah');
    }

    // Upload image summernote
    public function upload_image()
    {
        if ($image = $this->request->getFile('image')) {
            if ($image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                $image->move('./assets/img/', $newName);

                // Jika Anda ingin mengompres gambar, Anda dapat menambahkan kode di sini

                // Kembalikan URL gambar yang sudah di-upload agar dapat digunakan sebagai sumber gambar pada Summernote
                echo base_url('assets/img/' . $newName);
            } else {
                echo $image->getErrorString();
            }
        }
    }

    // Delete image summernote
    public function delete_image()
    {
        $filename = $this->request->getPost('filename');
        $filepath = './assets/img/' . $filename;

        if (file_exists($filepath)) {
            unlink($filepath);
            echo 'Image Deleted Successfully';
        } else {
            echo 'Image Not Found';
        }
    }
}
