<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMovieReactionsTable extends Migration
{
public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'INT',
            'constraint'     => 11,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'user_id' => [
            'type'       => 'INT',
            'constraint' => 11,
            'unsigned'   => true,
        ],
        'movie_id' => [
            'type'       => 'INT',
            'constraint' => 11,
            'unsigned'   => true,
        ],
        'reaction' => [
            'type'       => 'VARCHAR',
            'constraint' => '10',
        ],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addKey(['user_id', 'movie_id'], true);

    $this->forge->createTable('movie_reactions');

    $this->db->query("ALTER TABLE movie_reactions ADD CONSTRAINT reaction_check CHECK (reaction IN ('like', 'hate'))");
}

    public function down()
    {
        $this->forge->dropTable('movie_reactions');
    }
}