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
 * User upload data task
 *
 * @package     local_vetagropro
 * @category    task
 * @copyright   2020 CALL Learning <contact@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_vetagropro\task;

defined('MOODLE_INTERNAL') || die();

/**
 * Upload course catalog
 *
 * @package     local_vetagropro
 * @copyright   2019 CALL Learning <laurent@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_catalog_csv_upload extends \core\task\scheduled_task {

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     * @throws \coding_exception
     */
    public function get_name() {
        return get_string('coursecatalogdataupload', 'local_vetagropro');
    }

    /**
     * Send out messages.
     */
    public function execute() {
        global $CFG;
        if ($CFG->enablevetagropro) {
            static::process_catalog_csv();

        }
    }

    /**
     * Process user data from csv
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function process_catalog_csv() {
        $csvcousedatacatalog = get_config('local_vetagropro', 'coursecatalogfilepath');
        $delimiter = get_config('local_vetagropro', 'coursecatalogfiledelimiter');
        if (is_dir($csvcousedatacatalog)) {
            $filetoprocess = null;
            foreach (glob("{$csvcousedatacatalog}/*.csv") as $filename) {
                if (file_exists($filename) && is_file($filename)) {
                    $status = \local_vetagropro\importer\gescof_import::import($filename, $delimiter);

                    // Delete the file if imported successfully.
                    if ($status === true) {
                        unlink($filename);
                    }
                    break;
                }
            }
        }
    }
}

