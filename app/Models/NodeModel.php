<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EdgeModel;

class NodeModel extends Model
{
    protected $table = 'nodes';

    use HasFactory;

    public function edges()
    {
        return $this->hasMany(EdgeModel::class, 'start_node_id');
    }
}
