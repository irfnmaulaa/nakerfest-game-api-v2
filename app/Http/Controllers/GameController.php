<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function get_all_scores(Game $game)
    {
        $scores = $game->scores();
        if ($game->players_count >= 2) {
            $scores = $scores->orderBy('created_at')->get();
        } else {
            $scores = $scores->orderByDesc('player1_score')->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Scores retrieved successfully',
            'data' => [
                'game' => $game,
                'scores' => $scores,
            ]
        ]);
    }

    public function post_score(Request $request, Game $game)
    {
        $rules = [
            'player1_name' => ['required'],
            'player2_name' => ['nullable'],
            'player1_score' => ['required', 'numeric'],
            'player2_score' => ['nullable', 'numeric'],
        ];

        if ($game->players_count >= 2) {
            $rules['player2_name'] = ['required'];
            $rules['player2_score'] = ['required', 'numeric'];
        }

        $validated = $request->validate($rules);

        $game->scores()->create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Game score created successful',
        ], 200);
    }
}
