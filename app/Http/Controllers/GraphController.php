<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DijkstraService;
use App\Models\NodeModel;

class GraphController extends Controller
{
    //
    protected $dijkstraService;

    public function __construct(DijkstraService $dijkstraService)
    {
        $this->dijkstraService = $dijkstraService;
    }

    public function shortestPath($start, $end)
    {
        $startNode = NodeModel::where('name', $start)->firstOrFail();
        $endNode = NodeModel::where('name', $end)->firstOrFail();

        $path = $this->dijkstraService->shortestPath($startNode, $endNode);

        return response()->json([
            'path' => $path
        ]);
    }
}
