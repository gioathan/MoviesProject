<?php

namespace App\Controllers;

use App\Models\MovieReactionsModel;
use App\Models\MoviesModel;
use CodeIgniter\HTTP\ResponseInterface;

class MovieController extends BaseController
{
    public function react()
    {
        $session = session();

        if (!$session->has('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Login required.']);
        }

        $userId     = $session->get('user_id');
        $movieId    = $this->request->getJSON(true)['movie_id'];
        $reaction   = $this->request->getJSON(true)['reaction'];

        if (!in_array($reaction, ['like', 'hate'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid reaction.: Needs to be "like" or "hate".']);
        }

        $moviesModel = new MoviesModel();
        $movie       = $moviesModel->find($movieId);

        if (!$movie) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Movie not found.']);
        }

        if ($movie['user_id'] == $userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot react to your own movie.']);
        }

        $reactionModel = new MovieReactionsModel();

        $existingReaction = $reactionModel
            ->where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->first();

        if ($existingReaction) {
            if ($existingReaction['reaction'] !== $reaction) {

                $reactionModel->update($existingReaction['id'], ['reaction' => $reaction]);

                if ($reaction === 'like') {
                    $moviesModel->set('likes', 'likes + 1', false)
                                ->set('hates', 'hates - 1', false)
                                ->where('id', $movieId)->update();
                } else {
                    $moviesModel->set('likes', 'likes - 1', false)
                                ->set('hates', 'hates + 1', false)
                                ->where('id', $movieId)->update();
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Already reacted.']);
            }
        } else {
            $reactionModel->insert([
                'user_id'   => $userId,
                'movie_id'  => $movieId,
                'reaction'  => $reaction,
            ]);

            if ($reaction === 'like') {
                $moviesModel->set('likes', 'likes + 1', false)->where('id', $movieId)->update();
            } else {
                $moviesModel->set('hates', 'hates + 1', false)->where('id', $movieId)->update();
            }
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Reaction recorded.']);
    }
}
