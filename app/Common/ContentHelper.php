<?php

namespace App\Common;


use App\Constants\CommonConstants;

class ContentHelper
{
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

    public static function getGenderOptionsHtml($genderVal = null)
    {
        $genderVal = (string)$genderVal;

        $selectedAttr = '';
        if ($genderVal == 'null' || $genderVal == null) {
            $selectedAttr = 'selected';
        }
        $html = '<option ' . $selectedAttr . ' value="">' . __("Select Gender") . '</option>';

        $genders = ['male', 'female', 'other'];
        foreach ($genders as $gender) {
            $selectedAttr = '';
            $gender = (string)$gender;
            if ($genderVal == $gender) {
                $selectedAttr = 'selected';
            }
            $html .= '<option ' . $selectedAttr . ' value="' . $gender . '">' . ucwords($gender) . '</option>';
        }

        return $html;
    }

    public static function getYesNoHtml($activeStatus = null)
    {
        $activeStatus = (string)$activeStatus;

        $selectedAttr = '';
        if ($activeStatus == 'null' || $activeStatus == null) {
            $selectedAttr = 'selected';
        }
        $html = '<option ' . $selectedAttr . ' value="">' . __("--Select--") . '</option>';

        $selectedAttr = '';
        if ($activeStatus === (string)CommonConstants::YES) {
            $selectedAttr = 'selected';
        }
        $html .= '<option ' . $selectedAttr . ' value="' . CommonConstants::YES . '">' . __(ucfirst(CommonConstants::YES_STRING)) . '</option>';

        $selectedAttr = '';
        if ($activeStatus === (string)CommonConstants::NO) {
            $selectedAttr = 'selected';
        }
        $html .= '<option ' . $selectedAttr . ' value="' . CommonConstants::NO . '">' . __(ucfirst(CommonConstants::NO_STRING)) . '</option>';

        return $html;
    }

    public static function getDataTableOptions()
    {
        return [
            'sDom' => '<"tableFilters"><"tableHeader"<"tableHeaderStart"><"tableHeaderEnd">><"tableArea"t><"tableFooter"<"tableFooterStart"il><"tableFooterEnd"p>>',
            'processing' => true,
            'serverSide' => true,
            'destroy' => true,
            'pageLength' => 10,
            'sPaginationType' => "full_numbers",
            'lengthMenu' => [[10, 25, 50, 100, 250], [10, 25, 50, 100, 250]],
        ];
    }

    public static function getDaysOptionHtml($daySelected, $multiple = false)
    {
        if ($multiple) {
            if (is_string($daySelected)) {
                $daySelected = explode(',', $daySelected);
                $daySelected = Helper::cleanArray($daySelected);
            }else{
                if($daySelected == null){
                    $daySelected = [];
                }
            }
        }

        $selectedAttr = '';
        $html = '';

        $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        foreach ($days as $day) {
            $selectedAttr = '';
            $day = $day;
            if ($multiple) {
                if (in_array($day, $daySelected)) {
                    $selectedAttr = 'selected';
                }
            } else {
                if ($day == $daySelected) {
                    $selectedAttr = 'selected';
                }
            }
            $html .= '<option ' . $selectedAttr . ' value="' . $day . '">' . ucwords($day) . '</option>';
        }

        return $html;
    }


}
