<?php

namespace App\Http\Controllers;

use App\Services\AStarService;
use Illuminate\Http\Request;

class PathFindingController extends Controller
{
    //
    public function findPath(Request $request)
    {
        $start = $request->input('start', 'D');
        $goal = $request->input('goal', 'A');
        // $coordinates = [
        //     'A' => ['B' => [11212121212,434343434343,434343434343], 'C' => [12121212121,323232323232,44343434343434343]],
        //     'B' => ['A' => [11212121212,434343434343,434343434343], 'C' => [12121212121,323232323232,44343434343434343], 'D' => [123434353453,234234234242,5454654645645]]
        // ];
        // $graph = [
        //     'A' => ['B' => 11.0, 'C' => 2.5],
        //     'B' => ['A' => 10.0, 'D' => 1.0],
        //     'C' => ['A' => 2.5, 'D' => 1.5],
        //     'D' => ['B' => 1.0, 'C' => 1.5],
        // ];
        $graph = [
            'A' => ['B' => 5, 'C' => 8, 'D' => 1],
            'B' => ['A' => 5, 'D' => 5],
            'C' => ['A' => 8, 'D' => 8],
            'D' => ['B' => 5, 'C' => 8, 'A' => 1],
        ];
        $positions = [
            'A' => [40.7128, -74.0060],
            'B' => [41.8781, -87.6298],
            'C' => [34.0522, -118.2437],
            'D' => [29.7604, -95.3698],
        ];
        // $positions = [
        //     'A' => [0, 0],
        //     'B' => [1, 0],
        //     'C' => [0, 1],
        //     'D' => [1, 1],
        // ];
        
        $astar = new AStarService($graph, $positions);
        $path = $astar->findPath($start, $goal);

        return response()->json(['path' => $path]);
    }
}
