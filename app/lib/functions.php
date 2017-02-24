<?php

if ( ! function_exists('env'))
{
	/**
	* Gets the value of an environment variable. Supports boolean, empty and null.
	*
	* @param  string  $key
	* @param  mixed   $default
	* @return mixed
	*/
	function env($key, $default = null)
	{
		$value = getenv($key);

		if ($value === false) return value($default);

		switch (strtolower($value))
		{
			case 'true':
			case '(true)':
			return true;

			case 'false':
			case '(false)':
			return false;

			case 'empty':
			case '(empty)':
			return '';

			case 'null':
			case '(null)':
			return;
		}

		if (StringStartsWith($value, '"') && StringEndsWith($value, '"'))
		{
			return substr($value, 1, -1);
		}

		return $value;
	}
}

if ( ! function_exists('stringStartsWith'))
{
	/**
	 * Determine if a given string starts with a given substring.
	 *
	 * @param  string  $haystack
	 * @param  string|array  $needles
	 * @return bool
	 */
	function stringStartsWith($haystack, $needles)
	{
		foreach ((array) $needles as $needle)
		{
			if ($needle != '' && strpos($haystack, $needle) === 0) return true;
		}

		return false;
	}
}

if ( ! function_exists('stringEndsWith'))
{
	/**
	 * Determine if a given string ends with a given substring.
	 *
	 * @param  string  $haystack
	 * @param  string|array  $needles
	 * @return bool
	 */
	function stringEndsWith($haystack, $needles)
	{
		foreach ((array) $needles as $needle)
		{
			if ((string) $needle === substr($haystack, -strlen($needle))) return true;
		}

		return false;
	}
}