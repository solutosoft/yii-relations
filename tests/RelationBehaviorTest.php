<?php

namespace soluto\relations\tests;

use soluto\relations\RelationBehavior;
use soluto\relations\tests\models\Post;
//use soluto\relations\tests\models\PostLanguage;
//use soluto\relations\tests\models\Tag;

class RelationBehaviorTest extends TestCase
{
    public function testInitException()
    {
        $this->setExpectedException('\yii\base\InvalidConfigException');

        new RelationBehavior([
            'relations' => [
                ['invalid' => true]
            ]
        ]);
    }

    public function testInitSuccess()
    {
        new RelationBehavior([
            'relations' => [
                'relation_1',
                'relation_2' => [
                    'formName' => 'test'
                ]
            ]
        ]);
    }

    /*public function testFillNewRecord()
    {
        $post = new Post();
        $post->fill([
            'title' => 'modified title',
            'content' => 'modified content',
            'author_id' => 2,
            'tags' => [1, 2],
            'languages' => [
                [
                    'lang' => 'ja',
                    'url' => '/posts/ja'
                ],[
                    'lang' => 'en',
                    'url' => '/posts/en-modified'
                ]
            ]
        ]);

        $this->assertCount(2, $post->tags);
        $this->assertCount(2, $post->languages);

        $tag = $post->tags[0];

        $this->assertFalse($tag->getIsNewRecord());
        $lang = $post->languages[0];

        $this->assertTrue($lang->getIsNewRecord());

    }

    public function testSaveNewRecord()
    {
        $post = new Post();
        $post->fill([
            'title' => 'modified title',
            'content' => 'modified content',
            'author_id' => 2,
            'tags' => [1, 2],
            'languages' => [
                [
                    'lang' => 'ja',
                    'url' => '/posts/ja'
                ],[
                    'lang' => 'en',
                    'url' => '/posts/en-modified'
                ]
            ]
        ],'');


        $post->save();
        $this->assertCount(2, $post->tags);
        $this->assertCount(2, $post->languages);

        foreach ($post->languages as $lang) {
            $this->assertFalse($lang->getIsNewRecord());
        }
    }*/

    public function testSaveHasMany()
    {
        $post = Post::findOne(1);
        $post->fill([
            'title' => 'modified title',
            'content' => 'modified content',
            'author_id' => 2,
            'languages' => [
                [
                    'language' => 'ja',
                    'url' => '/posts/ja'
                ],[
                    'language' => 'en',
                    'url' => '/posts/en-modified'
                ]
            ]
        ],'');


        $post->save();
        $this->assertCount(2, $post->languages);

        $post->refresh();
        $this->assertCount(2, $post->languages);

    }

    public function testSaveHasManyViaTable()
    {
        $post = Post::findOne(1);
        $post->fill([
            'title' => 'modified title',
            'content' => 'modified content',
            'author_id' => 2,
            'tags' => [1, 3]
        ],'');


        $post->save();
        $this->assertCount(2, $post->tags);

        $post->refresh();
        $this->assertCount(2, $post->tags);

    }
}