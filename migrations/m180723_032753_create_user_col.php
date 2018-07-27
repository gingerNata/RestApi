<?php

class m180723_032753_create_user_col extends \yii\mongodb\Migration
{
    private $collection = 'user';

    public function up()
    {
        $this->createCollection($this->collection);
        $this->createIndex($this->collection, 'token');
        
        $this->insert($this->collection, [
            'name' => 'admin',
            'pass' => 'admin',
        ]);
    }

    public function down()
    {
        $this->dropIndex($this->collection, 'token');

        $this->dropCollection($this->collection);
    }
}
