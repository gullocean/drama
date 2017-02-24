<?php namespace Lib\Services\Search;

use Event, App;
use Symfony\Component\DomCrawler\Crawler;

class ImdbSearch implements SearchProviderInterface
{
	/**
	 * Scraper instance.
	 * 
	 * @var Lib\Services\Scraping\Curl
	 */
	private $scraper;

	/**
	 * Writer instance.
	 * 
	 * @var Lib\Services\Db\Writer
	 */
	private $writer;

	public function __construct()
	{
		$this->scraper = App::make('Lib\Services\Scraping\Curl');
		$this->writer = App::make('Lib\Services\Db\Writer');
	}


	/**
	 * Compile imdb search results html into view/db
	 * ready array.
	 * 
	 * @param  string $results
	 * @return array
	 */
	public function compileSearchResults($results)
	{
		$results = preg_replace('/<script(.*?)>(.*?)<\/script>/is', '', $results);
		$crawler = new crawler($results);
		
		//once we have the curl result cleaned, we can loop trough it and filter out all the results
		//matching our query.
		$sections = $crawler->filter('.lister-item');

		//store title,type,year to check for duplicates
		$check = '';
		$current = '';
			
		//then we will loop trough every result and extract the information we require(title, plot, cast etc.)
		foreach ($sections as $k => $value)
		{			
			$cr = new crawler($value);

			$title  = head($cr->filter('.lister-item-header a')->extract('_text'));
			$poster = $cr->filter('.lister-item-image img')->extract('loadlate');
			$rating = $cr->filter('.ratings-imdb-rating > strong')->extract('_text');
			$imdbid = $cr->filter('.lister-item-header a')->extract('href');
			$year = head($cr->filter('.lister-item-year')->extract('_text'));
			$runtime = head($cr->filter('.runtime')->extract('_text'));

			if ($runtime) {
				$runtime = explode(' ', $runtime)[0];
			}
				
			//set current title+year+type so we can spot duplicates
			$current = $title . $this->typeFromString($year) . $year;
	
			//if we already have such title+type+year increment year so we dont overwrite previous title
			if (strpos($check, $current) !== false) continue;
				
			$compiled[] = array(

				'imdb_id' => $this->imdbid($imdbid),
				'title'   => $title,
				'original_title' => $title,
				'type'    => $this->typeFromString($year, $runtime),
				'poster'  => $this->posterSize($poster),
				'year'    => $this->year($title),
				'plot'    => trim(head($cr->filter('.text-muted')->eq(2)->extract('_text'))),		
				'genre'   => trim(head($cr->filter('.genre')->extract('_text'))),
				'imdb_rating'  => $this->cleanRating($rating),
				'runtime' => trim( head($cr->filter('.runtime')->extract('_text')), ' min'),
				'imdb_votes_num' => head( $cr->filter('.sort-num_votes-visible span')->eq(1)->extract('data-value')),			
			);	

			if (isset($compiled[$k])) $check .= $compiled[$k]['title'] . $compiled[$k]['type'] . $compiled[$k]['year'];
		}
			
		return (isset($compiled) ? $compiled : array());
	}

	/**
	 * Extracts imdb id from string.
	 * 
	 * @param  array  $imdbid 
	 * @return string/void
	 */
	private function imdbid(array $imdbid)
	{
		if ( ! empty($imdbid))
		{
			preg_match('/(tt[0-9]+)\//', head($imdbid), $matches);

			if (isset($matches[1]))
			{
				return $matches[1];
			}
		}
	}

	/**
	 * Extracts movies release year from title.
	 * 
	 * @param  array  $title 
	 * @return void/string
	 */
	private function year($title)
	{
		if ($title)
		{
			preg_match('/([0-9]{4})/', $title, $matches);

			if (isset($matches[1]))
			{
				return $matches[1];
			}
		}

		return \Carbon\Carbon::now()->addYear()->year;
	}

	/**
	 * Change poster size of imdb url.
	 * 
	 * @param  array $url
	 * @return string/void
	 */
	private function posterSize(array $url)
	{
		//._V1._SY74_CR1,0,54,74_.jpg
		if ( ! empty($url))
		{
			//grab only part of the string that represents img size and crop
			$numbers = explode('V1', head($url));

			if ( ! isset($numbers[1]))
			{
				return null;
			}

			//multiply all size and crop numbers by 4
			$size = preg_replace_callback('/\d+/', function($tref) {
			    return $tref[0] * 4;
			}, $numbers[1]);

			return $numbers[0] . 'V1' . $size;
		}		
	}

	/**
	 * Figures out titles type.
	 * 
	 * @param  array  $string
	 * @return string/void
	 */
	private function typeFromString($year, $runtime = null)
	{
		if ($year) {
			if (str_contains($year, 'TV Movie'))
			{
				return 'movie';
			}
			elseif (str_contains($year, ['TV', '–']))
			{
				return 'series';
			}
		}

		if ($runtime && (int) $runtime <= 60) {
			return 'series';
		}

		return 'movie';
	}

	/**
	 * Proccesses search result ratings.
	 * 
	 * @param  array $rating
	 * @return string/void
	 */
	private function cleanRating(array $rating)
	{
		if (empty($rating)) return;

		//we'll run the string trough html entities so we can remove
		//all the unneccesary whitespace.
		$rating = trim( str_replace('&nbsp;', '', e( head($rating))));

		//extract votes from: 7.6/10 or similar
		preg_match('/([0-9].*?\/[0-9][0-9])/', $rating, $matches);

		if (isset($matches[0]))
		{
			return (float) explode('/', $matches[0])[0];
		} else {
			return (float) $rating;
		}
	}

	/**
	 * Searches for a title by query, inserts and returns it.
	 *
	 * @param  string $query
	 * @return array
	 */
	public function byQuery($query)
	{
		$url = $this->compileSearchUrl($query);

		//scrape and compile results for display in view
		$results = $this->scraper->curl($url);
		$compiled = $this->compileSearchResults($results);

		Event::fire('App.SearchResultsCompiled', array($compiled));

		return $this->writer->insertFromImdbSearch($compiled);
	}

	/**
	 * Compiles imdb advanced search url from query.
	 * 
	 * @param  string $query 
	 * @return string
	 */
	private function compileSearchUrl($query)
	{
		$query = preg_replace('/ /', '+', $query);

		$base = 'http://www.imdb.com/search/title?title=';
		$end  = '&title_type=feature,tv_movie,tv_series,tv_special,documentary&sort=num_votes&!genres=Adult';

		return $base . $query . $end;
	}
}