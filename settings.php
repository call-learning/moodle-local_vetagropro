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

if ($hassiteconfig) {
    global $CFG;
    $vetagropromanagement = new admin_category(
        'vetagropromanagement',
        get_string('vetagropromanagement', 'local_vetagropro')
    );

    $mainsettings = new admin_settingpage('vetagropromainsettings',
        get_string('vetagropromainsettings', 'local_vetagropro'),
        array('local/vetagropro:managesettings'),
        empty($CFG->enablevetagropro));

    $mainsettings->add(new admin_setting_configtext('local_vetagropro/coursecatalogfilepath',
        get_string('coursecatalogfilepath', 'local_vetagropro'),
        get_string('coursecatalogfilepath_desc', 'local_vetagropro'),
        \local_vetagropro\locallib\setup::DEFAULT_USERDATA_DIR));

    require_once($CFG->libdir . '/csvlib.class.php');
    $choices = csv_import_reader::get_delimiter_list();
    $mainsettings->add(new admin_setting_configselect(
        'local_vetagropro/coursecatalogfiledelimiter',
        get_string('coursecatalogfiledelimiter', 'local_vetagropro'),
        get_string('coursecatalogfiledelimiter_desc', 'local_vetagropro'),
        'semicolon',
        $choices));

    $vetagropromanagement->add('vetagropromanagement', $mainsettings);

    // Data management page.
    $pagedesc = get_string('coursecatalogdataupload', 'local_vetagropro');
    $pageurl = new moodle_url($CFG->wwwroot . '/local/vetagropro/admin/course_catalog_upload.php');
    $vetagropromanagement->add('vetagropromanagement',
        new admin_externalpage(
            'coursecatalogdataupload',
            $pagedesc,
            $pageurl,
            array('local/vetagropro:managesettings'),
            empty($CFG->enablevetagropro)
        )
    );

    // Logs page.
    $pagedesc = get_string('viewlogs', 'local_vetagropro');
    $pageurl = new moodle_url($CFG->wwwroot . '/local/vetagropro/admin/view_logs.php');
    $vetagropromanagement->add('vetagropromanagement',
        new admin_externalpage(
            'viewlogs',
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
