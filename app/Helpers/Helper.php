<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Session;

class Helper
{
    /* Action Colunm Button */

    public static function Action($editLink = '', $deleteID = '', $viewLink = '')
    {
        if ($editLink)
            $edit = '<a href="' . $editLink . '"  data-toggle="tooltip" title="Edit" class="btn btn-sm btn-clean btn-icon btn-icon-md"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></i></a>';
        else
            $edit = '';

        if ($deleteID)
            $delete = '<a onclick="deleteValueSet(' . $deleteID . ')"  class="btn btn-sm btn-clean btn-icon btn-icon-md"  title="Delete" data-toggle="modal" data-target="#delete-modal" >  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>';
        else
            $delete = '';

        if ($viewLink)
            $view = '<a  href="' . $viewLink . '" class="btn btn-sm btn-clean btn-icon btn-icon-md"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
        else
            $view = '';

        return $view . '' . $edit . '' . $delete;
    }
    /* Suopport Action Button */
    public static function supportActionbuttons($viewLink, $deleteId, $emailId)
    {
        if ($viewLink)
            $view = '<a title="View" href="' . $viewLink . '" class="btn btn-sm btn-clean btn-icon btn-icon-md"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
        else
            $view = '';

        if ($deleteId)
            $delete = '<a onclick="deleteValueSet(' . $deleteId . ')"  class="btn btn-sm btn-clean btn-icon btn-icon-md"  title="Delete" data-toggle="modal" data-target="#delete-modal" >  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>';
        else
            $delete = '';

        if ($emailId)
            $email = '<button data-toggle="modal" data-target="#send_email_modal" data-id=' . $deleteId . ' data-email=' . $emailId . '  title="Email" class="btn btn-sm btn-clean btn-icon btn-icon-md send_email_modal" title="Email"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></button>';
        else
            $email = '';

        return $view . '' . $delete . '' . $email;
    }

    /* Check Is System Generated Role */

    public static function IsSystemGeneratedRole($status)
    {
        if ($status == config('const.systemGeneratedRole')) {
            return '<span class="badge badge-pill badge-light-success mr-1">Yes</span>';
        } else {
            return '<span class="badge badge-pill badge-light-danger mr-1">No</span>';
        }
    }
    /* Get Timezone */

    public static function getTimezone()
    {
        if (Session::get('customTimeZone') && Session::get('customTimeZone') != '')
            return Session::get('customTimeZone');
        else
            return "Europe/Berlin";
    }


    /* Converted DateTime With Format */

    public static function displayDateTimeConvertedWithFormat($date, $format = '')
    {
        if (!$format) {
            $format = config('const.displayDateTimeFormatForAll');
        }

        $dt = new DateTime($date);
        $tz = new DateTimeZone(Helper::getTimezone()); // or whatever zone you're after

        $dt->setTimezone($tz);
        return $dt->format($format);
    }

    /*Display Status */

    public static function status($status)
    {
        if ($status == config('const.statusActiveInt')) {
            return '<span class="badge badge-pill badge-light-success mr-1">' . config('const.statusActive') . '</span>';
        } else if ($status == config('const.statusInActiveInt')) {
            return '<span class="badge badge-pill badge-light-warning mr-1">' . config('const.statusInActive') . '</span>';
        } else {
            return '<button type="button" class="btn red btn-xs pointerhide cursornone">---</button>';
        }
    }

    /* Display Support Status */
    static public function supportStatus($status)
    {
        if ($status == config('const.STATUS_OPEN_INT')) {
            return '<span class="badge badge-pill badge-light-primary mr-1">' . config('const.STATUS_OPEN_TEXT') . '</span>';
        } else if ($status == config('const.STATUS_REOPEN_INT')) {
            return '<span class="badge badge-pill badge-light-warning mr-1">' . config('const.STATUS_REOPEN_TEXT') . '</span>';
        } else if ($status == config('const.STATUS_CLOSE_INT')) {
            return '<span class="badge badge-pill badge-light-success mr-1">' . config('const.STATUS_CLOSE_TEXT') . '</span>';
        } else if ($status == config('const.STATUS_ONHOLD_INT')) {
            return '<span class="badge badge-pill badge-light-info mr-1">' . config('const.STATUS_ONHOLD_TEXT') . '</span>';
        } else {
            return '<button type="button" class="btn red btn-xs pointerhide cursornone">---</button>';
        }
    }

    /* Create Support Status */
    static public function supportStatuses()
    {
        return [
            config('const.STATUS_OPEN_INT') => config('const.STATUS_OPEN_TEXT'),
            config('const.STATUS_REOPEN_INT') => config('const.STATUS_REOPEN_TEXT'),
            config('const.STATUS_CLOSE_INT') => config('const.STATUS_CLOSE_TEXT'),
            config('const.STATUS_ONHOLD_INT') => config('const.STATUS_ONHOLD_TEXT'),
        ];
    }
    /* Create User Status */
    public static function userStatus()
    {
        return [
            config('const.statusActiveInt') => config('const.statusActive'),
            config('const.statusInActiveInt') => config('const.statusInActive'),
        ];
    }
}
