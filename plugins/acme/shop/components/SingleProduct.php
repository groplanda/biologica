<?php namespace Acme\Shop\Components;

use Acme\Shop\Models\Product;
use Acme\Shop\Models\Category;

class SingleProduct extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Товар',
            'description' => 'Показать товар'
        ];
    }


    function prepareVars()
    {
        $id = $this->param('slug');
        $query = Product::where('slug', '=', $id)->first();
       
        if($query == null) {
            return \Response::make($this->controller->run('404'), 404);
        } 
        $this->page['product'] = $query;
        $this->page['categories'] = Product::find($query->id)->categories()->first();
        $this->page['category_list'] = Category::all();
        
        $this->page->title = $this->page['product']->title;
        $this->page->meta_title = $this->page['product']->meta_title;
        $this->page->meta_description = $this->page['product']->meta_description;
        
        
    }

    public function onRun()
    { 
        $this->prepareVars();
    }

    
}