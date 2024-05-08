<?php

namespace App\Services;

use App\Models\NodeModel as Node;
use App\Models\EdgeModel;
use SplPriorityQueue;

class DijkstraService
{
    public function shortestPath($source, $target)
    {
        $nodes = Node::all();
        $dist = [];
        $previous = [];
        $queue = new \SplPriorityQueue();

        foreach ($nodes as $node) {
            // echo "node selected: $node\n"; // Debug output

            $dist[$node->id] = INF;
            $previous[$node->id] = null;
            $queue->insert($node->id, INF);
        }

        $dist[$source->id] = 0;
        $queue->insert($source->id, 0);

        while (!$queue->isEmpty()) {
            $minNode = $queue->extract();
            echo "Extracted NodeModel: $minNode\n"; // Debug output

            if ($minNode == $target->id) {
                $path = [];
                while ($previous[$minNode]) {
                    array_unshift($path, $minNode);
                    $minNode = $previous[$minNode];
                }
                array_unshift($path, $source->id);
                return $path;
            }

            if ($minNode != $target->id) {
                $nodeEdges = Node::find($minNode)->edges;
                // $nodeEdges = EdgeModel::where('current_position',$minNode)->get();
                foreach ($nodeEdges as $edge) {
                    $alt = $dist[$minNode] + $edge->cost;
                    echo "Considering Edge: {$edge->start_node_id} -> {$edge->end_node_id}, Cost: {$edge->cost}\n"; // Debug output
                    if ($alt < $dist[$edge->end_node_id]) {
                        $dist[$edge->end_node_id] = $alt;
                        $previous[$edge->end_node_id] = $minNode;
                        $queue->insert($edge->end_node_id, -$alt);
                    }
                }
            }
        }

        return [];
    }
}
