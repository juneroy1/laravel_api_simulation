<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BfsController extends Controller
{
    //
    public function shortestPath(Request $request)
    {
        $graph = [
            'A' => ['B', 'C'],
            'B' => ['C', 'D'],
            'C' => ['D'],
            'D' => []
        ];

        $start = 'A';
        $target = 'D';
        $path = $this->bfs($graph, $start, $target);

        return response()->json([
            'path' => $path
        ]);
    }

    private function bfs($graph, $start, $target)
    {
        $queue = new \SplQueue();
        $visited = [];
        $predecessor = [];
        $path = [];

        $queue->enqueue($start);
        $visited[$start] = true;

        while (!$queue->isEmpty()) {
            $vertex = $queue->dequeue();

            if ($vertex === $target) {
                // Reconstruct the path from end to start using the predecessor array
                while ($vertex !== $start) {
                    array_unshift($path, $vertex);
                    $vertex = $predecessor[$vertex];
                }
                array_unshift($path, $start);
                return $path;
            }

            foreach ($graph[$vertex] as $neighbor) {
                if (!isset($visited[$neighbor])) {
                    $visited[$neighbor] = true;
                    $predecessor[$neighbor] = $vertex;
                    $queue->enqueue($neighbor);
                }
            }
        }

        return "No path found";
    }
}
