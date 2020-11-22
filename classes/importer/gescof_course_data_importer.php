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
 * Course catalog import routine. Specific for gescof.
 *
 * This will add gescof enrolment plugin to the course if it does not exist.
 *
 * @package     local_vetagropro
 * @copyright   2020 CALL Learning <contact@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_vetagropro\importer;

use tool_importer\importer\course_data_importer;

defined('MOODLE_INTERNAL') || die();

/**
 * Class gescof_course_data_importer
 *
 * @package local_vetagropro\importer
 */
class gescof_course_data_importer extends course_data_importer {
    /**
     * GESCOF ENROL PLUGIN
     */
    const GESCOF_ENROL_NAME = 'gescof';

    /**
     * Callback after each row is imported.
     *
     * @param $row
     * @return mixed
     */
    public function after_row_imported($row, $data) {
        $course = $data; // This is what we get.
        // We have a course let's check if we need to add new enrollment.
        $enrol = enrol_get_plugin(self::GESCOF_ENROL_NAME);
        if (!empty($enrol)) {
            global $DB;
            $instances = enrol_get_instances($course->id, false);
            foreach ($instances as $instance) {
                if ($instance->enrol == self::GESCOF_ENROL_NAME) {
                    $inst = $instance;
                    break;
                }
            }
            $instancedata = (object) [
                'customchar1' => $course->shortname,
                'customchar2' => $course->cf_gescofpageurl
            ];
            if ($inst === null) {
                $instid = $enrol->add_instance($course,
                    $instancedata);
            } else {
                $enrol->update_instance($instance, $instancedata);
            }
        }
    }
}