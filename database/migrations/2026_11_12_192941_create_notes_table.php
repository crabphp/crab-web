<?php

declare(strict_types=1);

use Crab\Contracts\Database\Migration;
use Crab\Contracts\Database\Schema;
use Crab\Contracts\Database\Table;

return new class implements Migration {
    public function up(Schema $schema): void
    {
        $schema->create('notes', function (Table $table) {
            $table->id();
            $table->string('text', 200);
            $table->timestamps();
        });
    }

    public function down(Schema $schema): void
    {
        $schema->drop('notes');
    }
};
