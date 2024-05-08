<?php

namespace App\Services;

use App\Models\NodeModel as Node;
use App\Models\EdgeModel;
use SplPriorityQueue;

class DijkstraService
{
    public function shortestPath($source, $target)
    {
        $dist = [];
        $previous = [];
        $queue = new SplPriorityQueue();

        // Initialize distances and previous nodes
        $nodes = Node::all();
        foreach ($nodes as $node) {
            $dist[$node->id] = INF;
            $previous[$node->id] = null;
            // Insert with negative priority to get lowest distance first
            $queue->insert($node->id, -INF);
        }

        // Set source node distance to zero
        $dist[$source->id] = 0;
        $queue->insert($source->id, 0);

        // Process the priority queue
        while (!$queue->isEmpty()) {
            // Extract the node with the lowest distance
            $currentNode = $queue->extract();
            echo "Extracted NodeModel: $currentNode\n"; // Debug output

            // Stop if the destination node is reached
            if ($currentNode == $target->id) {
                $path = [];

                // Build the path backward using the previous map
                while ($currentNode !== null) {
                    array_unshift($path, $currentNode);
                    $currentNode = $previous[$currentNode];
                }

                return $path;
            }

            // Retrieve edges connected to this node
            $nodeEdges = Node::find($currentNode)->edges;
            foreach ($nodeEdges as $edge) {
                $alt = $dist[$currentNode] + $edge->cost;
                echo "Considering Edge: {$edge->start_node_id} -> {$edge->end_node_id}, Cost: {$edge->cost}\n"; // Debug output

                // Only update if a shorter path is found
                if ($alt < $dist[$edge->end_node_id]) {
                    $dist[$edge->end_node_id] = $alt;
                    $previous[$edge->end_node_id] = $currentNode;

                    // Re-insert with updated priority
                    $queue->insert($edge->end_node_id, -$alt);
                }
            }
        }

        // Return an empty path if no valid path is found
        return [];
    }
}
