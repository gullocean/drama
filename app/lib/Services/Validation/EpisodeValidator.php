<?php namespace Lib\Services\Validation;

class EpisodeValidator extends AbstractValidator
{
	public $rules = array(

		'title'     	 => 'min:1|max:255',
		'episode_number' => 'required|numeric|min:1',
		'plot' 	    	 => 'min:1',
		'release_date'   => 'min:4|max:255',
		'poster'    	 => 'min:1, max:255',
		'title_id'		 => 'required|numeric',
		'season_id'		 => 'required|numeric',
		'season_number'	 => 'required|numeric'
		
		);

}