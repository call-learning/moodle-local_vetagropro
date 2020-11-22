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
 * Task (scheduled) for this module
 *
 * @package     local_vetagropro
 * @copyright   2020 CALL Learning <contact@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_vetagropro\locallib;

defined('MOODLE_INTERNAL') || die();

class setup {
    const SYLLABUS_CATEGORY_NAME = 'Champs Syllabus';

    /**
     * This sets up the basic parameters for this plugin.
     *
     * This function should stay idempotent in any case (several runs results in the same setup).
     */
    public static function install_update($fielddefpath = null, $catalogcsvpath=null) {
        global $CFG;
        // Global settings for Vetagropro.
        // This assumes that dependent plugins are installed too.

        // Set base course view URL (the syllabus page).
        set_config('courseviewbaseurl','/local/syllabus/view.php', 'local_resourcelibrary');

        // Set the category name for syllabus fields.
        set_config('syllabuscategoryname',self::SYLLABUS_CATEGORY_NAME, 'local_syllabus');

        // Set the name of the menu for the ressource library catalog.
        set_config('menutextoverride','Catalogue de cours|fr\nCourse Catalog|en', 'local_resourcelibrary');

        // Make sure we do not activate Activity Library.
        set_config('activateactivitylibrary',false, 'local_resourcelibrary');

        // Set the catalog url for the enrol_gescof.
        if (!get_config('enrol_gescof', 'migalurl')) {
            set_config('migalurl', 'http://formationcontinue.vetagro-sup.fr/formation', 'enrol_gescof');
        }
        if (!$fielddefpath) {
            $fielddefpath = $CFG->dirroot.'/local/vetagropro/cli/files/customfields_defs.txt';
        }
        set_config('customfielddef',
            file_get_contents($fielddefpath), 'local_syllabus');
        \local_syllabus\locallib\utils::create_customfields_fromdef();
        if ($catalogcsvpath) {
            \local_vetagropro\importer\gescof_import::import($catalogcsvpath);
        }
    }
}