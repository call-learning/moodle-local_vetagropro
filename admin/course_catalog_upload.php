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
 * User Data management page
 *
 * @package     local_vetagropro
 * @copyright   2020 CALL Learning <contact@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true); // Progress bar is used here.
require_once(__DIR__ . '../../../../config.php');
global $CFG, $PAGE, $OUTPUT;
require_once($CFG->libdir . '/adminlib.php');
require_once('course_catalog_upload_form.php');

admin_externalpage_setup('coursecatalogdataupload');
require_login();

// Override pagetype to show blocks properly.
$header = get_string('coursecatalogdataupload', 'local_vetagropro');
$PAGE->set_title($header);
$PAGE->set_heading($header);
$PAGE->set_cacheable(false);    // Progress bar is used here.
$backurl  = new moodle_url('/admin/category.php', array('category' => 'vetagropromanagement'));
$PAGE->set_button($PAGE->button
    . $OUTPUT->single_button($backurl, get_string('vetagropromanagement', 'local_vetagropro'), 'get'));
$pageurl = new moodle_url($CFG->wwwroot . '/local/vetagropro/admin/course_catalog_upload.php');

$PAGE->set_url($pageurl);

$mform = new course_catalog_upload_form();

$default = [];
if (get_config('local_vetagropro', 'coursecatalogfilepath')) {
    $default['coursecatalogfilepath'] = get_config('local_vetagropro', 'coursecatalogfilepath');
}
$message = "";
if ($mform->is_cancelled()) {
    redirect($pageurl);
} else if ($data = $mform->get_data()) {
    if ($mform->get_new_filename('filetoupload')) {
        echo $OUTPUT->header();
        $tempfile = $mform->save_temp_file('filetoupload');
        $delimiter = $data->delimiter_name;
        require_sesskey();
        $progressbar = new progress_bar();
        $progressbar->create();
        $status = \local_vetagropro\importer\gescof_import::import($tempfile, $delimiter, $progressbar);
        if ($status === true) {
            /* @var $OUTPUT core_renderer Core renderer */
            echo $OUTPUT->box(get_string('catalogdataimported', 'local_vetagropro'), 'notifysuccess');
        } else {

            echo $OUTPUT->box(get_string('catalogdataimporterror',
                'local_vetagropro'),
                'notifyfailure'
            );
        }
        unlink($tempfile); // Remove temp file.
        $viewlogurl = new moodle_url('/local/vetagropro/admin/view_logs.php');
        echo $OUTPUT->continue_button($viewlogurl, get_string('continue'), 'get');
        echo $OUTPUT->footer();
        die();
    }
}

$mform->set_data($default);

echo $OUTPUT->header();
echo $message;
$mform->display();
echo $OUTPUT->footer();
