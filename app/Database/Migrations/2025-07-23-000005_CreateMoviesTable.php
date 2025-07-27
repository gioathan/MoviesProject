<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMoviesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'  => ['type' => 'TEXT'],
            'user_id'      => ['type' => 'INT', 'unsigned' => true],
            'likes'        => ['type' => 'INT', 'default' => 0],
            'hates'        => ['type' => 'INT', 'default' => 0],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('movies');
    }

    public function down()
    {
        $this->forge->dropTable('movies');
    }
}