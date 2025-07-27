<?php

namespace App\Models;

use CodeIgniter\Model;

class MoviesModel extends Model
{
    protected $table      = 'movies';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'user_id', 'likes', 'hates', 'published_at'];

    public function countMovies($user_id = null)
    {
        if ($user_id !== null) {
            return $this->where('user_id', $user_id)->countAllResults();
        }

        return $this->countAll();
    }

    public function getUserMovies($user_id = null, $sort_by = 'recent')
    {
        $builder = $this->db->table('movies');
        $builder->select('movies.*, users.firstname, users.lastname');
        $builder->join('users', 'users.id = movies.user_id');

        if ($user_id !== null) {
            $builder->where('movies.user_id', $user_id);
        }

        switch ($sort_by) {
            case 'likes':
                $builder->orderBy('movies.likes', 'DESC');
                break;
            case 'hates':
                $builder->orderBy('movies.hates', 'DESC');
                break;
            case 'recent':
            default:
                $builder->orderBy('movies.published_at', 'DESC');
                break;
        }

        return $builder->get()->getResultArray();
    }
}
