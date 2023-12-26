<?php namespace WebReinvent\VaahCms\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;


class VaahModel extends Model
{
    //-------------------------------------------------

    //-------------------------------------------------
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: function (string $value = null) {
                return self::getUserTimezoneDate($value);
            },
        );
    }

    //-------------------------------------------------
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: function (string $value = null) {
                return self::getUserTimezoneDate($value);
            },
        );
    }

    //-------------------------------------------------
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: function (string $value = null) {
                return self::getUserTimezoneDate($value);
            },
        );
    }

    //-------------------------------------------------
    public static function getUserTimezoneDate($value)
    {
        if(!$value){
            return null;
        }

        $timezone = Session::get('user_timezone');

        if(\Auth::check() && \Auth::user()->timezone){
            $timezone = \Auth::user()->timezone;
        }

        if(!$timezone){
            return $value;
        }

        return \Carbon::parse(strtotime($value))
            ->setTimezone($timezone)
            ->format(config('settings.global.datetime_format','Y-m-d H:i:s'));

    }
    //-------------------------------------------------
}
