<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostsExport implements FromCollection
{
    public function collection()
    {
        return Post::where('status', 'published')->get();
    }
}
