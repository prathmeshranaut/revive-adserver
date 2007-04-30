<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: Timezone.php 6032 2007-04-25 16:12:07Z aj@seagullproject.org $
*/

/**
 * A class for retrieving a list of avaiable timezone for the proper locale.
 *
 * @package    Openads
 * @author     Alexander J. Tarachanowicz II <aj@seagullproject.org>
 */

 class MAX_Admin_Timezones
 {
    function AvailableTimezones()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];

        //  get current language
        $lang = (!empty($pref['language'])) ? $pref['language'] : $conf['max']['language'];

        if (!empty($lang)) {
            //  check if timezone file exists for language stored in prefs
            if (file_exists(MAX_PATH . '/lib/max/language/' . $lang . '/timezone.lang.php')) {
                include_once MAX_PATH . '/lib/max/language/' . $lang . '/timezone.lang.php';
                return $tz;
            //  load default if it does not exist
            } else {
                return false;
            }
        }
    }

    function getTimezone()
    {
        if (version_compare(phpversion(), '5.1.0', '>=')) {
            $tz = date_default_timezone_get();
        } elseif (getenv('TZ') === false) {
            $tz = getenv('TZ');
        }

        //  get timezone from date if not set
        if (empty($tz)) {
                $diff = date('O') / 100;
                $tz = 'GMT'.($diff > 0 ? '-' : '+').abs($diff);
        }

        return (!empty($tz)) ? $tz : false;
    }
}