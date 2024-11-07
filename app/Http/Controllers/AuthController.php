<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //  
    public function register(Request $request){
        
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user'
        ],201);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // $credentials = $request(['email','passowrd']);
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Unauthorized',
            ],401);
            
        }

        $user = $request->user();
        $tokenResult = $user->createToken('juneroytest1')->accessToken;

        // $token = $tokenResult->plainTextToken;

        // $user->save();

        return response()->json([
            'access_token' =>$tokenResult,
            'token_type' => 'Bearer'
        ]);
    }


    public function test_dijkstra(){
        // Example usage
            $graph = [
                'A' => ['B' => 3, 'C' => 1, 'D' => 9],
                'B' => ['A' => 3, 'C' => 3, 'D' => 4, 'E' => 7],
                'C' => ['A' => 5, 'B' => 3, 'D' => 2, 'F' => 8],
                'D' => ['A' => 9, 'B' => 4, 'C' => 2, 'E' => 2, 'F' => 2],
                'E' => ['B' => 7, 'D' => 2, 'F' => 5],
                'F' => ['C' => 8, 'D' => 2, 'E' => 5]
            ];

            list($distances, $paths) = $this->dijkstra($graph, 'F');

            return response()->json([
                'distances' => $distances,
                'paths' => $paths
            ]);
        }

    public function dijkstra($graph, $source){
        $dist = [];
        $prev = [];
        $queue = new \SplPriorityQueue();
    
        foreach ($graph as $vertex => $adj) {
            $dist[$vertex] = PHP_INT_MAX;
            $prev[$vertex] = null;
            $queue->insert($vertex, PHP_INT_MAX);
        }
    
        $dist[$source] = 0;
        $queue->insert($source, 0);
        $queue->setExtractFlags(\SplPriorityQueue::EXTR_DATA);
    
        while (!$queue->isEmpty()) {
            $u = $queue->extract();
    
            if ($dist[$u] == PHP_INT_MAX) {
                break;
            }
    
            foreach ($graph[$u] as $v => $cost) {
                $alt = $dist[$u] + $cost;
                if ($alt < $dist[$v]) {
                    $dist[$v] = $alt;
                    $prev[$v] = $u;
                    $queue->insert($v, -$alt);
                }
            }
        }
    
        return [$dist, $prev];
    }
  
}
