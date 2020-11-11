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
 * Course catalog import routine
 *
 * @package     local_vetagropro
 * @copyright   2020 CALL Learning <contact@call-learning.fr>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_vetagropro\importer;

use tool_importer\source\csv_data_source;

defined('MOODLE_INTERNAL') || die();

class gescof_csv_data_source extends csv_data_source {

    /**
     *
     * @return array
     */
    public function get_fields_definition() {
        return array(
            'CodeProduit' => \tool_importer\field_types::TYPE_TEXT,
            'IntituleProduit' => \tool_importer\field_types::TYPE_TEXT,
            'AccrocheCom' => \tool_importer\field_types::TYPE_TEXT,
            'ResumeProduit' => \tool_importer\field_types::TYPE_TEXT,
            'Objectifs' => \tool_importer\field_types::TYPE_TEXT,
            'PreRequis' => \tool_importer\field_types::TYPE_TEXT,
            'Contenu' => \tool_importer\field_types::TYPE_TEXT,
            'Evaluation' => \tool_importer\field_types::TYPE_TEXT,
            'Pedagogie' => \tool_importer\field_types::TYPE_TEXT,
            'Observations' => \tool_importer\field_types::TYPE_TEXT,
            'NbHeures' => \tool_importer\field_types::TYPE_TEXT,
            'NbJours' => \tool_importer\field_types::TYPE_TEXT,
            'CoutTotalHT' => \tool_importer\field_types::TYPE_TEXT,
            'NiveauFormation' => \tool_importer\field_types::TYPE_TEXT,
            'FamilleProduits' => \tool_importer\field_types::TYPE_TEXT,
            'EffectifMaxi' => \tool_importer\field_types::TYPE_TEXT,
            'EffectifMini' => \tool_importer\field_types::TYPE_TEXT,
            'TypePublic' => \tool_importer\field_types::TYPE_TEXT,
            'TypeIntervenant' => \tool_importer\field_types::TYPE_TEXT,
        );
    }
}