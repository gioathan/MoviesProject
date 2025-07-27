<?php

namespace App\Controllers;

use App\Models\MoviesModel;
use App\Models\MovieReactionsModel;

class Home extends BaseController
{
    public function index()
    {
        $sort_by = $this->request->getGet('sort_by') ?? 'recent';

        $moviesModel = new MoviesModel();
        $movies = $moviesModel->getUserMovies(null, $sort_by); // all users

        $user_id = session('user_id');
        $reactionModel = new MovieReactionsModel();

        foreach ($movies as &$movie) {
            if ($user_id && $user_id != $movie['user_id']) {
                $reaction = $reactionModel->where('user_id', $user_id)
                                        ->where('movie_id', $movie['id'])
                                        ->first();
                $movie['user_reaction'] = $reaction['reaction'] ?? null;
            } else {
                $movie['user_reaction'] = null;
            }
        }
        

        return view('movies', [
            'movies'  => $movies,
            'sort_by' => $sort_by,
            'user_id' => null
        ]);
    }
}

