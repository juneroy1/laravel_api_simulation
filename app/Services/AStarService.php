<?php
namespace App\Services;

use SplPriorityQueue;

class AStarService
{
    private $positions;
    private $graph;

    public function __construct($graph, $positions)
    {
        $this->graph = $graph;
        $this->positions = $positions;
    }

    public function findPath($start, $goal)
    {
        $queue = new SplPriorityQueue();
        $queue->insert($start, 0);
        $cameFrom = [];
        $gScore = [$start => 0];
        $fScore = [$start => $this->heuristic($start, $goal)];
        $closedSet = [];
        
        while (!$queue->isEmpty()) {
            $current = $queue->extract();
            if ($current === $goal) {
                return $this->reconstructPath($cameFrom, $current);
            }
            $closedSet[$current] = true;

            foreach ($this->graph[$current] ?? [] as $neighbor => $cost) {
                if (!empty($closedSet[$neighbor])) {
                    continue;
                }
                $tentativeGScore = floatval($gScore[$current]) + floatval($cost);
                // echo "$current";
                // echo "$neighbor - $gScore[$current] '-' $cost\n";
                // echo "$neighbor - $gScore[$neighbor] '-' $cost\n";
                // echo "$cost\n";
                if (!isset($gScore[$neighbor]) || $tentativeGScore < $gScore[$neighbor]) {
                    $cameFrom[$neighbor] = $current;
                    $gScore[$neighbor] = $tentativeGScore;
                    $fScore[$neighbor] = $tentativeGScore + $this->heuristic($neighbor, $goal);
                    $fs = $this->heuristic($neighbor, $goal);
                    echo "$fs \n";
                    $queue->insert($neighbor, -$fScore[$neighbor]);
                }
            }
        }
        

        return null;
    }

    private function reconstructPath($cameFrom, $current)
    {
        $path = [];
        while (isset($cameFrom[$current])) {
            $path[] = $current;
            $current = $cameFrom[$current];
        }
        $path[] = $current;
        return array_reverse($path);
    }

    private function heuristic($node1, $node2)
    {
        $lat1 = deg2rad($this->positions[$node1][0]);
        $lon1 = deg2rad($this->positions[$node1][1]);
        $lat2 = deg2rad($this->positions[$node2][0]);
        $lon2 = deg2rad($this->positions[$node2][1]);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return 6371 * $c; // Earth's radius in kilometers
    }
}


?>