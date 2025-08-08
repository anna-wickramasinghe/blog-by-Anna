<?php

namespace App\Imports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToModel;

class PostsImport implements ToModel
{
    public function model(array $row)
    {
        return new Post([
            'title'  => $row[0],
            'body'   => $row[1],
            'status' => $row[2],
            'user_id' => Auth::id()
        ]);
    }
}