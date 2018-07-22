<?php

class m180721_085056_create_pages_col extends \yii\mongodb\Migration
{
    private $collection = 'pages';

    public function up()
    {
        $this->createCollection($this->collection);

        $this->createIndex($this->collection, 'name');
        $this->createIndex($this->collection, 'title');
        $this->createIndex($this->collection, 'create');
        $this->createIndex($this->collection, 'update');
        $this->createIndex($this->collection, 'url', ['unique' => true]);
        $this->createIndex($this->collection, 'status');
        $this->createIndex($this->collection, 'tags');


        require __DIR__ . '/../vendor/joshtronic/php-loremipsum/src/LoremIpsum.php';
        $lipsum = new joshtronic\LoremIpsum();
        
        for($i = 0; $i < 1000000; $i++) {
            $this->insert(
                $this->collection, [
                'name'     => $lipsum->words(3),
                'title'    => $lipsum->words(4),
                'create'   => date('m/d/Y h:i:s', time()),
                'update'   => date('m/d/Y h:i:s', time()),
                'url'      => strtolower($lipsum->word()) . $i,
                'status'   => 1,
                'tags'     => [$lipsum->word(), $lipsum->word()],
                'metatags' => $lipsum->words(2),
                'content'  => $lipsum->sentences(5)
            ]);
        }
    }

    public function down()
    {
        $this->dropIndex($this->collection, 'name');
        $this->dropIndex($this->collection, 'title');
        $this->dropIndex($this->collection, 'create');
        $this->dropIndex($this->collection, 'update');
        $this->dropIndex($this->collection, 'url');
        $this->dropIndex($this->collection, 'status');
        $this->dropIndex($this->collection, 'tags');

        $this->dropCollection($this->collection);
    }
}
