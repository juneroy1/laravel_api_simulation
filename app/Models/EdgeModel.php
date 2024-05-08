<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NodeModel;

class EdgeModel extends Model
{   
    protected $table = 'edges';
    use HasFactory;

    public function startNode()
    {
        return $this->belongsTo(NodeModel::class, 'start_node_id');
    }

    public function endNode()
    {
        return $this->belongsTo(NodeModel::class, 'end_node_id');
    }
}
