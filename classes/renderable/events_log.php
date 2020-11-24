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
 * Course catalog import log
 *
 * @package     local_vetagropro
 * @copyright   2020 CALL Learning <contact@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_vetagropro\renderable;
defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;

/**
 * Class userdata_log
 *
 * @package local_vetagropro
 * @copyright   2019 CALL Learning <laurent@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class events_log implements renderable, templatable {

    public $eventname = null;

    public function __construct($eventname = '\\local_vetagropro\\event\\course_catalog_imported') {
        $this->eventname = $eventname;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output
     * @return \stdClass
     */
    public function export_for_template(renderer_base $output) {
        $context = new \stdClass();
        $context->userdatalog = [];
        $logmanager = get_log_manager();
        $readers = $logmanager->get_readers();
        $store = $readers['logstore_standard'];
        $allevents = $store->get_events_select('eventname = :eventname',
            array('eventname' => $this->eventname), 'timecreated DESC',
            0, 0);
        $context->columns = ['timecreated'];
        foreach (array_values($allevents) as $index => $evt) {
            $data = $evt->get_data();
            $other = $data['other'];
            if (!$index) {
                $context->columns = array_merge($context->columns,
                    array_keys($other));
            }
            $context->userdatalog[] = array('values' =>
                array_merge(
                    [userdate($data['timecreated'])], array_values($other)
            )
            );
        }
        return $context;
    }
}
