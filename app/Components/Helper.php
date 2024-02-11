<?php

namespace App\Components;

use App\Constants\CommonConstants;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;

class Helper
{
    public static function frontendWithBaseUrl($url)
    {
        return rtrim(env('APP_URL'),"/")."/frontend/".$url;
    }

    public static function dashboardLink()
    {
        if(!auth()->guest()) {
            if (auth()->user()->isAdmin()) {
                return route('admin.dashboard');
            } else {
                return route('user.dashboard');
            }
        }
        return route('home');
    }

    public static function fetchIpDetails($ip, $fetchCountry = false, $fetchState = false, $fetchCity = false)
    {
        if ($ip == "::1") {
            return null;
        }
        $location = Location::get($ip);
        if (!$location) {
            return null;
        }
        $location = $location->toArray();

        $location['country'] = null;
        $location['state'] = null;
        $location['city'] = null;

        if (is_array($location)) {

            if ($fetchCountry && array_key_exists('countryCode', $location)) {
                $location['country'] = Country::getCountryFromCountryCode($location['countryCode']);
            }

            if ($fetchState && $location['country'] != null && array_key_exists('regionName', $location)) {
                $location['state'] = State::getStateFromName($location['country'], $location['regionName']);
            }

            if ($fetchCity && $location['state'] != null && array_key_exists('cityName', $location)) {
                $location['city'] = City::getCityFromName($location['state'], $location['cityName']);
            }

        }
        return $location;
    }

    public static function displayTime($time, $format = CommonConstants::DISPLAY_DATE_TIME_FORMAT)
    {
        if ($time == null) {
            return '-';
        }
        $time = strtotime($time);
        return date($format, $time);
    }

    public static function printBadge($text, $class = 'badge badge-info')
    {
        return '<span class="' . $class . '">' . $text . '</span>';
    }

    public static function getActionButtons($links, $extraHtml = '')
    {
        $haveLink = false;
        $html = '<div class="pxp-dashboard-table-options"><ul class="list-unstyled">';

        if (is_array($links) && count($links) > 0) {
            foreach ($links as $action => $link) {

                $visible = true;
                if (array_key_exists('visible', $link)) {
                    $visible = $link['visible'];
                }

                if ($visible) {

                    $haveLink = true;
                    $extraAttributes = [];

                    if (array_key_exists('url', $link)) {
                        $url = $link['url'];
                        $icon = $text = '';
                        if (array_key_exists('text', $link)) {
                            $text = $link['text'];
                        } else {
                            $text = ucwords($action);
                        }
                        if (array_key_exists('icon', $link)) {
                            $icon = $link['icon'];
                        } else {
                            switch ($action) {
                                case 'view':
                                    $icon = 'la la-eye';
                                    break;
                                case 'edit':
                                    $icon = 'la la-pencil';
                                    break;
                                case 'delete':
                                    $icon = 'las la-trash';
                                    break;
                            }
                        }

                        if (array_key_exists('extra', $link)) {
                            foreach ($link['extra'] as $attributeName => $attributeValue) {
                                $extraAttributes[] = $attributeName . '="' . $attributeValue . '"';
                            }
                        }

                        $is_form = false;
                        if (array_key_exists('is_form', $link)) {
                            $is_form = $link['is_form'];
                        }

                        $target = '_self';
                        if (array_key_exists('target', $link)) {
                            $target = $link['target'];
                        }

                        if ($is_form) {
                            $html .= '<li ' . implode(' ', $extraAttributes) . '><form class="delete-modal-form" action="' . $url . '" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <button type="submit" title="' . $text . '"><i class="' . $icon . '"></i></button>
                            </form></li>';
                        } else {
                            $html .= '<li><a ' . implode(' ', $extraAttributes) . ' target="' . $target . '" href="' . $url . '" title="' . $text . '"><i class="' . $icon . '"></i></a></li>';
                        }
                    }

                }
            }
        }

        $html .= $extraHtml;
        $html .= '</ul></div>';

        if (!$haveLink && $extraHtml == null) {
            $html = '-';
        }
        return $html;
    }

    public static function menuActiveClass($routes, $excludeRoutes = null, $activeClass = 'active')
    {
        $haveActiveClass = false;
        $currentRouteName = Request::route()->getName();

        if (is_string($routes)) {
            if (Request::is($routes)) {
                $haveActiveClass = true;
            }
        } else {
            if (is_array($routes) && in_array($currentRouteName, $routes)) {
                $haveActiveClass = true;
            }
            foreach ($routes as $route) {
                if (Request::is($route)) {
                    $haveActiveClass = true;
                }
            }
        }

        if (is_array($excludeRoutes) && in_array($currentRouteName, $excludeRoutes)) {
            $haveActiveClass = false;
        }

        if ($haveActiveClass) {
            return $activeClass;
        }
        return '';
    }

    public static function printYesNoBadge($value)
    {
        $status = CommonConstants::YES_NO_PROPERTIES[$value];
        return Helper::printBadge($status['text'], $status['class']);
    }

    public static function getDashboardStats(User $identity)
    {
        $stats = [];

        if ($identity->isTeacher()) {
            $batches = CourseBatch::where('user_id', $identity->id)->count();
            if ($batches == null) {
                $batches = 0;
            }
            $students = UserCourse::where('teacher_id', $identity->id)->groupBy('user_id')->get();
            $students = count($students);

            $stats['total_batches'] = $batches;
            $stats['total_students'] = $students;
        }

        if ($identity->isStudent()) {
            $courses = UserCourse::where('user_id', $identity->id)->groupBy('course_id')->get();
            $courses = count($courses);
            $stats['total_courses'] = $courses;;
        }

        return $stats;
    }

    public static function printNumber($number)
    {
        if ($number > 0) {
            $number = number_format($number, 2);
        } else {
            $number = 0;
        }
        $number = str_replace('.00', '', $number);
        return $number;
    }

    public static function printDate($time)
    {
        if ($time != '') {
            return date(CommonConstants::PHP_DATE_FORMAT, strtotime($time));
        }
        return '-';
    }

    public static function printAmount($amount)
    {
        return CommonConstants::CURRENCY_ICON . self::printNumber($amount);
    }

    public static function withAppUrl($path)
    {
        $appUrl = env('APP_URL');
        $appUrl = rtrim($appUrl, '/');
        $appUrl = ltrim($appUrl, '/');
        $path = ltrim($path, '/');
        return $appUrl . "/" . $path;
    }

    public static function uploadedFile($path){
        return self::withAppUrl('storage/'.$path);
    }

    public static function datesBetweenDates($first, $last, $output_format = CommonConstants::PHP_DATE_FORMAT_SHORT, $step = '+1 day')
    {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    public static function printUnderScoreText($text)
    {
        return ucwords(str_replace('_', ' ', $text));
    }

    public static function removeEmptyItems($values)
    {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                if (is_string($value)) {
                    $value = trim($value);
                    if ($value == '') {
                        unset($values[$key]);
                    }
                }
            }
        }
        return $values;
    }

    public static function printCountry(Country $country, $includeName = true)
    {
        $html = '<span class="countryItem"><span class="flag flag-' . strtolower($country->iso) . '"></span>';
        if ($includeName) {
            $html .= '<span class="countryName">' . $country->name . '</span>';
        }
        $html .= '</span>';
        return $html;
    }

    public static function printJsonText($value)
    {
        $html = [];
        if ($value != null) {
            $data = json_decode($value, true);
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $key => $value) {
                    $html[] = $key . ': ' . $value;
                }
            }
            $html = implode(', ', $html);
        } else {
            $html = '-';
        }
        return $html;
    }

    public static function getCountries($countryIds = [])
    {
        if (is_array($countryIds) && count($countryIds) > 0) {
            return Country::whereIn('id', $countryIds)->get();
        }
        return [];
    }

    public static function isFileIsValidImage(\Illuminate\Http\UploadedFile $image)
    {
        $allowedExtensions = ['jpg', 'jpeg', 'zip', 'png', 'webp'];
        $originalName = $image->getClientOriginalName();
        $nameExtracted = explode('.', $originalName);
        $extension = end($nameExtracted);
        if (in_array($extension, $allowedExtensions)) {
            return true;
        } else {
            return "File extension not allowed, Allowed Extensions are:- " . implode(', ', $allowedExtensions);
        }
    }

    public static function getSettingValue($settingId)
    {
        $setting = Setting::where('id', $settingId)->first();
        if ($setting != null) {
            return trim($setting->value);
        }
        return null;
    }

    public static function getAllSettings()
    {
        $data = [];
        $settings = Setting::all();
        if ($settings != null) {
            foreach ($settings as $setting) {
                $data[$setting->id] = trim($setting->value);
            }
        }
        return $data;
    }

    public static function errorsToString(\Illuminate\Support\MessageBag $errors)
    {
        $errors = $errors->all();
        $messages = [];
        if ($errors != null) {
            foreach ($errors as $error) {
                if (is_string($error)) {
                    $messages[] = $error;
                } else {
                    if (is_array($error)) {
                        foreach ($error as $singleError) {
                            $messages[] = $singleError;
                        }
                    }
                }
            }
        }
        return implode(' ', $messages);
    }

    public static function getUploadPath($subDir)
    {
        $dir = storage_path('app/public');
        $dir = rtrim($dir, '/');
        $dir = $dir . '/' . $subDir;
        File::ensureDirectoryExists($dir);
        $dir = rtrim($dir, '/');
        return $dir . "/";
    }

    public static function getViewPath($subDir = '', $path = '')
    {
        return '/storage/' . $subDir . '/' . $path;
    }

    public static function getTimeAgo($time)
    {
        return Carbon::parse($time)->diffForHumans();
    }

    public static function inRequest($key, $value)
    {
        $value = trim($value);
        if (isset($_GET[$key])) {
            $queryVal = $_GET[$key];
            if (is_array($queryVal) && count($queryVal) > 0) {
                foreach ($queryVal as $k => $val) {
                    $val = trim($val);
                    if ($val == $value) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function cleanArray($list)
    {
        if (is_array($list) && count($list) > 0) {
            foreach ($list as $k => $v) {
                if (is_array($v)) {
                    $v = self::cleanArray($v);
                    if (is_array($v) && count($v) <= 0) {
                        unset($k);
                    }
                } else {
                    $v = trim($v);
                    if ($v == null) {
                        unset($k);
                    }
                }
            }
        }
        return $list;
    }

    public static function getCurrentFullUrl()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public static function getUsernameFromEmail($email)
    {
        $email = trim($email);
        if ($email != null) {
            $emailExplode = explode('@', $email);
            if (is_array($emailExplode) && array_key_exists(0, $emailExplode)) {
                $username = $emailExplode[0];
                return Helper::checkAndGetUsername($username);
            }
        }
        return null;
    }

    private static function checkAndGetUsername($username, $sno = 0)
    {
        $user = User::where('username', $username)->first();
        if (!empty($user)) {
            $sno++;
            if ($sno > 0) {
                $username .= $sno;
            }
            return self::checkAndGetUsername($username, $sno);
        } else {
            return $username;
        }
    }

    public static function getNthText($number)
    {
        switch ($number) {
            case 1:
                return 'st';
                break;
            case 2:
                return 'nd';
                break;
            case 3:
                return 'rd';
                break;
            default:
                return 'th';
                break;
        }
    }

    public static function parseMassInputError($error, $startFrom)
    {
        $regex = '/' . $startFrom . '.(.*[0-9]).(.*[a-zA-Z0-9]) field/iUsm';
        preg_match($regex, $error, $matches);
        if (is_array($matches) && array_key_exists('1', $matches) && array_key_exists('2', $matches)) {
            $boxCount = $matches[1] + 1;
            $boxCountNth = Helper::getNthText($boxCount);
            $error = ucwords(Helper::printUnderScoreText($matches[2])) . " field in " . ($boxCount) . $boxCountNth . " box is Required";
        }
        return $error;
    }

    public static function currentLocale()
    {
        $locale = Config::get('app.locale');
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        $allowedLocales = Config::get('app.available_locales');
        if (is_array($allowedLocales) && array_key_exists($locale, $allowedLocales)) {
            return $allowedLocales[$locale];
        }
        return null;
    }

    /**
     * @param string $email
     * @return string valid|invalid|notfound
     */
    public static function validateEmailFromZeroBounce($email)
    {
        try {
            ZeroBounce::Instance()->initialize(env('ZERO_BOUNCE_API_KEY'));
            $response = ZeroBounce::Instance()->validate($email);
            $status = $response->status;
            switch ($status) {
                case 'catch-all':
                case 'unknown':
                    return 'notfound';
                case 'invalid':
                case 'spamtrap':
                case 'abuse':
                case 'do_not_mail':
                    return 'invalid';
                case 'valid':
                    return 'valid';
            }
        } catch (\Exception $ex) {

        }
        return 'notfound';
    }

    public static function getAdminUser()
    {
        $adminUser = User::where('role_id', UserConstants::ROLE_ADMIN)->first();
        if ($adminUser == null) {
            $adminUser = User::where('username', 'admin')->first();
        }
        return $adminUser;
    }

    public static function getLayoutForUser()
    {
        if (auth()->user()) {
            $identity = auth()->user();
            if ($identity->isAdmin()) {
                return 'layouts.backend';
            }
        }
        return 'layouts.frontend';
    }

    public static function slugify($string)
    {
        $string = str_replace(' ', '_', $string);
        $string = str_replace('-', '_', $string);
        $string = strtolower($string);
        return $string;
    }

    public static function uploadFile($fileAttr)
    {
        $fileName = time() . '_' . Helper::slugify(request()->file($fileAttr)->getClientOriginalName());
        $filePath = request()->file($fileAttr)->storeAs('uploads/' . $fileAttr, $fileName, 'public');
        return $filePath;
    }

    public static function haveWeekendDays($days)
    {
        if (is_array($days)) {
            if (in_array('saturday', $days)) {
                return true;
            }
            if (in_array('sunday', $days)) {
                return true;
            }
        }
        return false;
    }

    public static function getDurationInMinutes($startTime, $endTime)
    {
        $minutes = strtotime($endTime) - strtotime($startTime);
        if ($minutes > 0) {
            $minutes = $minutes / 60;
        }
        return $minutes;
    }

    public static function getCurrentUserId()
    {
        if (auth()->user()) {
            return auth()->user()->id;
        }
        return null;
    }

    public static function getEndDateForSomeDaysPerWeek($daysAllowed, $totalDays, $startDate = null)
    {
        $endDate = null;
        if ($startDate == null) {
            $startDate = date(CommonConstants::PHP_DATE_FORMAT);
        }
        if ($totalDays > 0) {
            if (is_array($daysAllowed) && count($daysAllowed) > 0) {
                $nextDay = $startDate;
                $daysFound = 0;
                while ($daysFound < $totalDays) {
                    $nextDayTimeStamp = strtotime("+1 day", strtotime($nextDay));
                    $nextDay = date(CommonConstants::PHP_DATE_FORMAT, $nextDayTimeStamp);
                    $dayName = strtolower(date('l', $nextDayTimeStamp));
                    //echo $nextDay.' -> '.$dayName.'</br>';
                    if (in_array($dayName, $daysAllowed)) {
                        $daysFound++;
                    }
                    //echo 'FOUND '.$daysFound."</br>";
                }
                if ($daysFound >= $totalDays) {
                    $endDate = $nextDay;
                }
            }
        }
        return $endDate;
    }

    public static function isAdmin()
    {
        if (auth()->user() && auth()->user()->isAdmin()) {
            return true;
        }
        return false;
    }

    public static function haveValueInList($value, $collection)
    {
        if ($collection != null) {
            if (!is_array($collection)) {
                $collection = explode(',', $collection);
            }
        }
        if (is_array($collection) && count($collection) > 0) {
            foreach ($collection as $item) {
                if ($item == $value) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function addTime($startTime, $duration, $type = 'minutes')
    {
        return date("H:i", strtotime('+' . $duration . ' ' . $type, strtotime($startTime)));
    }

    public static function getTodayDates()
    {
        return [
            'start' => date(CommonConstants::PHP_DATE_FORMAT_SHORT) . " 00:00:00",
            'end' => date(CommonConstants::PHP_DATE_FORMAT_SHORT) . " 23:59:59",
        ];
    }
}
