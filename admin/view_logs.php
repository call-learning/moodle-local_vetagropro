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
 * View logs
 *
 * @package     local_vetagropro
 * @copyright   2020 CALL Learning <contact@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true); // Progress bar is used here.
require_once(__DIR__ . '../../../../config.php');
global $CFG, $PAGE, $OUTPUT;
require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('viewlogs');
require_login();

// Override pagetype to show blocks properly.
$header = get_string('viewlogs', 'local_vetagropro');
$PAGE->set_title($header);
$PAGE->set_heading($header);
$pageurl = new moodle_url($CFG->wwwroot . '/local/vetagropro/admin/view_logs.php');
$PAGE->set_url($pageurl);
$backurl  = new moodle_url('/admin/category.php', array('category' => 'vetagropromanagement'));

$PAGE->set_button($PAGE->button
    . $OUTPUT->single_button($backurl, get_string('vetagropromanagement', 'local_vetagropro'), 'get'));

$renderer = $PAGE->get_renderer('local_vetagropro');
$renderable = new local_vetagropro\renderable\events_log();

echo $OUTPUT->header();
echo $renderer->render($renderable);
echo $OUTPUT->footer();
