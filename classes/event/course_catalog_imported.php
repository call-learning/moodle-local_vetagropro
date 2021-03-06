<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * User data imported
 *
 * @package     local_vetagropro
 * @category    task
 * @copyright   2020 CALL Learning <contact@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_vetagropro\event;

use core\event\base;

defined('MOODLE_INTERNAL') || die();

/**
 * Class course_catalog_imported
 *
 * Message sent /created when a course catalog is imported
 *
 * @package local_vetagropro
 * @copyright   2019 CALL Learning <laurent@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_catalog_imported extends \core\event\base {
    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('coursecatalogimported', 'local_vetagropro');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        $filename = s($this->other['filename']);
        $error = s($this->other['error']);
        return "CSV User data has been imported ({$filename})" . ($error ?
                " and the following error occured: ($error)" :
                ""
            );
    }

    /**
     * Get the backup/restore table mapping for this event.
     *
     * @return string
     */
    public static function get_objectid_mapping() {
        return base::NOT_MAPPED;
    }

    /**
     * No mapping
     *
     * @return array|false
     */
    public static function get_other_mapping() {
        // Nothing to map.
        return false;
    }
}
