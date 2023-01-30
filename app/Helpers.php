<?php 

/**
 * Global Helper
 *
 * "I treat my works as my own child, be careful with my childrens"
 *
 * Created with love and proud by Ghivarra Senandika Rushdie
 *
 * @package Company Profile Website
 *
 * @var https://github.com/ghivarra
 * @var https://facebook.com/bcvgr
 * @var https://twitter.com/ghivarra
 * @var https://instagram.com/ghivarra
 *
**/

/**
 *
 * idtime
 *
 * @param string    $param
 * @param int       $time
 *
 * @return string   $string
 *
**/
if(!function_exists('id_time'))
{
    function id_time($param, $time)
    {
        $config = new App();

        // new intl date formatter
        $intlDate = new IntlDateFormatter(env('TIME_LOCALE'), IntlDateFormatter::FULL, IntlDateFormatter::FULL, env('TIME_ZONE'), IntlDateFormatter::GREGORIAN, $param);

        // return and replace shitty locale Pebruari in windows
        return str_replace(['Pebruari', 'pebruari', 'Peb', 'peb'], ['Februari', 'februari', 'Feb', 'feb'], $intlDate->format($time));
    }
}