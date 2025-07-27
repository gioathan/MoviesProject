<?php

namespace App\Models;

use CodeIgniter\Model;

class MovieReactionsModel extends Model
{
    protected $table = 'movie_reactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'movie_id', 'reaction'];
    public $timestamps = false;
}
