<?php

namespace CodePress\CodeTag\Testing;


use CodePress\CodeTag\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTagsTest extends \TestCase
{
    use DatabaseTransactions;

    public function test_can_visit_admin_tags_page()
    {
        $this->visit('/admin/tags')
            ->see('tags!');
    }

    public function test_tags_listing()
    {
        Tag::create(array('name' => 'Tag_1', 'active' => true));
        Tag::create(array('name' => 'Tag_2', 'active' => false));
        Tag::create(array('name' => 'Tag_3', 'active' => false));
        Tag::create(array('name' => 'Tag_4', 'active' => true));

        $this->visit('/admin/tags')
            ->see('Tag_1')
            ->see('Tag_2')
            ->see('Tag_3')
            ->see('Tag_4');
    }

    public function test_click_create_new_Tag()
    {
        $this->visit('admin/tags')
            ->click('Create Tag')
            ->seePageIs('/admin/tags/create')
            ->see('Create Tag');
    }

    public function test_create_new_Tag()
    {
        $this->visit('admin/tags/create')
            ->type('Tag_test', 'name')
            ->press('btn_submit')
            ->seePageIs('/admin/tags')
            ->see('Tag_test');
    }

    public function test_update_a_Tag()
    {
        $tag = Tag::all()->last();
        $this->visit("admin/tags/{$tag->id}/edit")
            ->type('Tag_test_updated', 'name')
            ->press('btn_submit')
            ->seePageIs('/admin/tags')
            ->see('Tag_test_updated');
    }

    public function test_delete_a_Tag()
    {
        $this->visit('admin/tags')
            ->click('Delete')
            ->dontSee('Tag_1');
    }
}
