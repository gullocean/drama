<?php namespace Plugins\Streaming\Plugin\Lib\Categories;

use DB, App;
use Lib\Categories\CategoriesRepository;

class StreamingCategoriesRepository extends CategoriesRepository
{

	public function __construct()
	{
        $category = App::make('Category');

        parent::__construct($category);
	}

    /**
     * Return all categories.
     * 
     * @return Collection
     */
    public function all()
    {
        $model = $this->model->with(array('Title.Link', 'Actor'))->orderBy('weight', 'desc')->get();

        //sort by pivot created_at here, because laravels sort is bugged
        //when using from closure when lazy loading relationships
        foreach ($model as $category) {
            $rel = $category->title->isEmpty() ? 'actor' : 'title';

            $category->{$rel}->sortByDesc(function($model) {
                return $model->pivot->created_at;
            });
        }


        return $model;
    }
}