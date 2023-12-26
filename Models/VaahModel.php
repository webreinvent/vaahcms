<?php namespace WebReinvent\VaahCms\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;


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
        return \Carbon::parse(strtotime($value))
            ->setTimezone(\Auth::user()->timezone)
            ->format(config('settings.global.datetime_format'));

    }
    //-------------------------------------------------
}
