<?php
// This file is part of Moodle - https://moodle.org/
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
 * Plugin administration pages are defined here.
 *
 * @package     local_vetagropro
 * @category    admin
 * @copyright   2020 CALL Learning <contact@call-learning.fr>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    global $CFG;
    $vetagropromanagement = new admin_category(
        'vetagropromanagement',
        get_string('vetagropromanagement', 'local_vetagropro')
    );
    // Data management page.
    $pagedesc = get_string('coursecatalogdatamanagement', 'local_vetagropro');
    $pageurl = new moodle_url($CFG->wwwroot . '/local/vetagropro/admin/course_catalog.php');
    $vetagropromanagement->add('vetagropromanagement',
        new admin_externalpage(
            'coursecatalogdatamanagement',
            $pagedesc,
            $pageurl,
            array('local/vetagropro:managesettings'),
            empty($CFG->enablevetagropro)
        )
    );
    if (!empty($CFG->enablevetagropro)) {
        $ADMIN->add('root', $vetagropromanagement);
    }

    // Create a global Advanced Feature Toggle.
    $optionalsubsystems = $ADMIN->locate('optionalsubsystems');
    $optionalsubsystems->add(new admin_setting_configcheckbox('enablevetagropro',
            new lang_string('enablevetagropro', 'local_vetagropro'),
            new lang_string('enablevetagropro_help', 'local_vetagropro'),
            1)
    );
}
