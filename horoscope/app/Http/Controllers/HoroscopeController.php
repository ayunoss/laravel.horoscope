<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Util\Json;

class HoroscopeController extends Controller {
    private const API_LINK_PART = 'http://ohmanda.com/api/horoscope/';

    public function showBirthDayForm() {
        return view('birthdateform');
    }

    public function showHoroscope(Request $request) {
        $date = $request->get('date');
        $sign = $this->_getSignByDate($date);
        $info = $this->getHoroscopeInfo($sign);
        return view('horoscope', ['sign' => $sign, 'info' => $info]);
    }

    private function _getSignByDate($date) {
        $dateTime = new \DateTime($date);
        $preparedDate = $dateTime->format('m-d');
        $dateForComparison = \DateTime::createFromFormat('m-d', $preparedDate);
        foreach ($this->_signsPeriods() as $info) {
            if ($dateForComparison >= $info['start'] && $dateForComparison <= $info['end']) {
                return $sign = $info['name'];
            }
        }
        throw new \Exception("Unable to detect sign for date {$date}");
    }

    public function getHoroscopeInfo($sign) {

        $api_link = self::API_LINK_PART.strtolower($sign);
        $jsonRaw = file_get_contents($api_link);
        $json = $this->_fixCorruptedJson($jsonRaw);
        $data = json_decode($json, true);
    }

    private function _fixCorruptedJson(string $json): string {
        $bracePosition = strpos($json, '}');
        return substr($json, 0, ++$bracePosition);
    }

    private function _signsPeriods() {
        return [
            [
                'name' => 'Aries',
                'start' => \DateTime::createFromFormat('m-d', '03-21'),
                'end' => \DateTime::createFromFormat('m-d', '04-20'),
            ],
            [
                'name' => 'Taurus',
                'start' => \DateTime::createFromFormat('m-d', '04-21'),
                'end' => \DateTime::createFromFormat('m-d', '05-21'),
            ],
            [
                'name' => 'Gemini',
                'start' => \DateTime::createFromFormat('m-d', '05-22'),
                'end' => \DateTime::createFromFormat('m-d', '06-21'),
            ],
            [
                'name' => 'Cancer',
                'start' => \DateTime::createFromFormat('m-d', '06-22'),
                'end' => \DateTime::createFromFormat('m-d', '07-22'),
            ],
            [
                'name' => 'Leo',
                'start' => \DateTime::createFromFormat('m-d', '07-23'),
                'end' => \DateTime::createFromFormat('m-d', '08-23'),
            ],
            [
                'name' => 'Virgo',
                'start' => \DateTime::createFromFormat('m-d', '08-24'),
                'end' => \DateTime::createFromFormat('m-d', '09-22'),
            ],
            [
                'name' => 'Libro',
                'start' => \DateTime::createFromFormat('m-d', '09-23'),
                'end' => \DateTime::createFromFormat('m-d', '10-23'),
            ],
            [
                'name' => 'Scorpio',
                'start' => \DateTime::createFromFormat('m-d', '10-24'),
                'end' => \DateTime::createFromFormat('m-d', '11-22'),
            ],
            [
                'name' => 'Sagittarius',
                'start' => \DateTime::createFromFormat('m-d', '11-23'),
                'end' => \DateTime::createFromFormat('m-d', '12-21'),
            ],
            [
                'name' => 'Capricorn',
                'start' => \DateTime::createFromFormat('m-d', '12-22'),
                'end' => \DateTime::createFromFormat('m-d', '01-20'),
            ],
            [
                'name' => 'Aquarius',
                'start' => \DateTime::createFromFormat('m-d', '01-21'),
                'end' => \DateTime::createFromFormat('m-d', '02-18'),
            ],
            [
                'name' => 'Pisces',
                'start' => \DateTime::createFromFormat('m-d', '02-19'),
                'end' => \DateTime::createFromFormat('m-d', '03-20'),
            ]
        ];
    }
}
