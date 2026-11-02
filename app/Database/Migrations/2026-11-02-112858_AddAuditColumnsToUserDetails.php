<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddAuditColumnsToUserDetails extends Migration
{
    public function up()
    {
        $fields = [
            'created_date' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],

            'update_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],

            'updated_by' => [
                'type' => 'INT',
                'null' => true,
                'default' => null,
            ],
        ];

        $this->forge->addColumn('user_details', $fields);

    }

    public function down()
    {
        $this->forge->dropColumn('user_details',[
            'created_date',
            'update_date',
            'updated_by',
        ]);


    }
}
