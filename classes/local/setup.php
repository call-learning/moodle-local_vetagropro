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
namespace local_vetagropro\local;

defined('MOODLE_INTERNAL') || die();

class setup {
    /**
     * This sets up the basic parameters for this plugin.
     *
     * This function should stay idempotent in any case (several runs results in the same setup).
     */
    public static function install_update() {
        // Global settings for Vetagropro.
        // This assumes that dependent plugins are installed too.
        set_config('courseviewbaseurl','/local/syllabus/view.php', 'local_resourcelibrary');
    }
}