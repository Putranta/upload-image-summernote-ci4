<?php

namespace App\Models;

use CodeIgniter\Model;

class Post_model extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'contents'];

    // Tambahkan metode lain sesuai dengan kebutuhan Anda, misalnya metode untuk mengambil data artikel berdasarkan ID.
}
