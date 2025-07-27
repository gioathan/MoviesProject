<?php

namespace App\Controllers;

use App\Models\MoviesModel;
use App\Models\MovieReactionsModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class User extends BaseController
{
    public function index($user_id = null)
    {
        $sort_by = $this->request->getGet('sort_by') ?? 'recent';
        
        $moviesModel = new MoviesModel();
        $movies = $moviesModel->getUserMovies($user_id, $sort_by);

        $logged_user_id = session('user_id');
        $reactionModel = new MovieReactionsModel();

        foreach ($movies as &$movie) {
            if ($logged_user_id && $logged_user_id != $movie['user_id']) {
                $reaction = $reactionModel->where('user_id', $logged_user_id)
                                          ->where('movie_id', $movie['id'])
                                          ->first();
                $movie['user_reaction'] = $reaction['reaction'] ?? null;
            } else {
                $movie['user_reaction'] = null;
            }
        }

        $userModel = new UserModel();
        try {
            $user = $userModel->getFullName($user_id);

            return view('movies', [
                'movies'   => $movies,
                'sort_by'  => $sort_by,
                'user_id'  => $user_id,
                'user_name' => $user['firstname'] . ' ' . $user['lastname']
            ]);
        } catch (\Exception $e) {
            throw PageNotFoundException::forPageNotFound("User not found.");
        }
    }

    public function addMovieForm($user_id)
    {
        if (!session()->has('user_id') || session('user_id') != $user_id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('add_movie', ['user_id' => $user_id]);
    }

    public function submitMovie($user_id)
    {
        if (!session()->has('user_id') || session('user_id') != $user_id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|max_length[255]',
            'description' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $moviesModel = new MoviesModel();
        $moviesModel->insert([
            'user_id' => $user_id,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'published_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to("/user/$user_id")->with('success', 'Movie added successfully!');
    }
}