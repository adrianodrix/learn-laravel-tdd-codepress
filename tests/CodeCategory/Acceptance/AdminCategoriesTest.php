<?php

namespace CodePress\CodeCategory\Testing;


use CodePress\CodeCategory\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class AdminCategoriesTest extends \TestCase
{
    use DatabaseTransactions;

    public function test_can_visit_admin_categories_page()
    {
        $this->visit('/admin/categories')
            ->see('Categories!');
    }

    public function test_categories_listing()
    {
        Category::truncate();

        Category::create(array('name' => 'Category_1', 'active' => true));
        Category::create(array('name' => 'Category_2', 'active' => false));
        Category::create(array('name' => 'Category_3', 'active' => false));
        Category::create(array('name' => 'Category_4', 'active' => true));

        $this->visit('/admin/categories')
            ->see('Category_1')
            ->see('Category_2')
            ->see('Category_3')
            ->see('Category_4');
    }

    public function test_click_create_new_category()
    {
        $this->visit('admin/categories')
            ->click('Create Category')
            ->seePageIs('/admin/categories/create')
            ->see('Create Category');
    }

    public function test_create_new_category()
    {
        $this->visit('admin/categories/create')
            ->type('category_test', 'name')
            ->check('active')
            ->press('btn_submit')
            ->seePageIs('/admin/categories')
            ->see('category_test');
    }

    public function test_update_a_category()
    {
        $category = Category::all()->first();
        $this->visit("admin/categories/{$category->id}/edit")
            ->type('category_test_updated', 'name')
            ->check('active')
            ->press('btn_submit')
            ->seePageIs('/admin/categories')
            ->see('category_test_updated');
    }

    public function test_delete_a_category()
    {
        $this->visit('admin/categories')
            ->click('Delete')
            ->dontSee('Category_1');
    }
}
