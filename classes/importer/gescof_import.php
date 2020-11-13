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
defined('MOODLE_INTERNAL') || die();

use tool_importer\importer;

class gescof_import {
    /**
     * Import the csv file in the given path
     *
     * @param $csvpath
     * @throws \dml_exception
     * @throws \tool_importer\importer_exception
     */
    public static function import($csvpath) {
        $csvimporter = new gescof_csv_data_source($csvpath);
        function capitalize($value, $columnname) {
            return ucfirst(strtolower($value));
        }
        function with_title($value, $columnname) {
            $stringm = get_string_manager();
            $titlecontent = ucfirst(strtolower($columnname));
            if ($stringm->string_exists('summary:' . strtolower($columnname), 'local_vetagropro')) {
                $titlecontent = get_string('summary:' . strtolower($columnname), 'local_vetagropro');
            }
            $title = \html_writer::tag('h3', $titlecontent);
            $content = \html_writer::span(clean_param($value, PARAM_CLEANHTML), 'summary-' . strtolower($columnname));
            if (in_array(trim(strtolower($content)), array('', 'null'))) {
                return '';
            }
            return $title . $content;
        }
        $transformdef = array(
            'CodeProduit' => array(array('to' => 'idnumber'), array('to' => 'shortname')),
            'IntituleProduit' => array(array('to' => 'fullname',
                'transformcallback' => __NAMESPACE__ .'\capitalize')),
            'AccrocheCom' => array(array('to' => 'summary',
                'transformcallback' => __NAMESPACE__ .'\with_title',
                'concatenate' => ['order' => 0])),
            'ResumeProduit' => array(array('to' => 'summary',
                'transformcallback' => __NAMESPACE__ .'\with_title',
                'concatenate' => ['order' => 1])),
            'Objectifs' => array(array('to' => 'summary',
                'transformcallback' => __NAMESPACE__ .'\with_title',
                'concatenate' => ['order' => 2])),
            'PreRequis' => array(array('to' => 'summary',
                'transformcallback' => __NAMESPACE__ .'\with_title',
                'concatenate' => ['order' => 3])),
            'Contenu' => array(array('to' => 'summary', 'transformcallback' => '\\local_vetagropro\\with_title',
                'concatenate' => ['order' => 4])),
            'Evaluation' => array(array('to' => 'summary',
                'transformcallback' => __NAMESPACE__ .'\with_title',
                'concatenate' => ['order' => 5])),
            'Pedagogie' => array(array('to' => 'summary',
                'transformcallback' => __NAMESPACE__ .'\with_title',
                'concatenate' => ['order' => 6])),
            'Observations' => array(array('to' => 'summary',
                'transformcallback' => __NAMESPACE__ .'\with_title',
                'concatenate' => ['order' => 7])),
            'NbHeures' => array(array('to' => 'cf_heures')),
            'NbJours' => array(array('to' => 'cf_jours')),
            'CoutTotalHT' => array(array('to' => 'cf_prix')),
            'NiveauFormation' => array(array('to' => 'cf_niveauformation')),
            'FamilleProduits' => array(array('to' => 'cf_theme')),
            'EffectifMaxi' => array(array('to' => 'cf_effectifmax')),
            'EffectifMini' => array(array('to' => 'cf_effectifmin')),
            'TypePublic' => array(array('to' => 'cf_typepublic')),
            'TypeIntervenant' => array(array('to' => 'cf_typeintervenant')),
        );

        $transformer = new \tool_importer\transformer\standard($transformdef);

        $importer = new importer($csvimporter,
            $transformer,
            new importer\course_data_importer());
        $importer->import();
    }
}