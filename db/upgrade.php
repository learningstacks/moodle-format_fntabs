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
 * @package    format_fntabs
 * @copyright  Michael Gardener <mgardener@cissq.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xmldb_format_fntabs_upgrade($version) {

    if ($version < 2016090600) {
        global $DB;
        $dbman = $DB->get_manager();

        if ($dbman->table_exists('course_config_fn')) {
            $table = new xmldb_table('course_config_fn');
            $dbman->drop_table($table);
        }

        if ($dbman->table_exists('fn_coursemodule_extra')) {
            $table = new xmldb_table('fn_coursemodule_extra');
            $dbman->drop_table($table);
        }

        // Define table format_fntabs_color to be created.
        $table = new xmldb_table('format_fntabs_color');

        // Adding fields to table format_fntabs_color.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '18', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, '');
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '18', null, null, null, null);
        $table->add_field('bgcolour', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('activecolour', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('selectedcolour', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('inactivecolour', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('inactivebgcolour', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('activelinkcolour', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('selectedlinkcolour', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('inactivelinkcolour', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('predefined', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table format_fntabs_color.
        $table->add_key('id', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table format_fntabs_color.
        $table->add_index('mdl_formnedtabsconf_cou_ix', XMLDB_INDEX_NOTUNIQUE, array('courseid'));

        // Conditionally launch create table for format_fntabs_color.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);

            $rec = new stdClass();
            $rec->name = 'Embassy Green';
            $rec->courseid = 1;
            $rec->bgcolour = '9DBB61';
            $rec->activecolour = 'DBE6C4';
            $rec->selectedcolour = 'FFFF33';
            $rec->inactivecolour = 'BDBBBB';
            $rec->inactivebgcolour = 'F5E49C';
            $rec->activelinkcolour = '000000';
            $rec->selectedlinkcolour = '000000';
            $rec->inactivelinkcolour = '000000';
            $rec->predefined = 1;
            $rec->timecreated = time();
            $DB->insert_record('format_fntabs_color', $rec);

            $rec = new stdClass();
            $rec->name = 'Blues on Whyte';
            $rec->courseid = 1;
            $rec->bgcolour = 'FFFFFF';
            $rec->activecolour = 'E1E1E1';
            $rec->selectedcolour = '7CAAFE';
            $rec->inactivecolour = 'BDBBBB';
            $rec->inactivebgcolour = 'F5E49C';
            $rec->activelinkcolour = '929292';
            $rec->selectedlinkcolour = 'FFFFFF';
            $rec->inactivelinkcolour = '929292';
            $rec->predefined = 1;
            $rec->timecreated = time();
            $DB->insert_record('format_fntabs_color', $rec);
        }

        // Define table format_fntabs_cm to be created.
        $table = new xmldb_table('format_fntabs_cm');

        // Adding fields to table format_fntabs_cm.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '18', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '18', null, XMLDB_NOTNULL, null, null);
        $table->add_field('cmid', XMLDB_TYPE_INTEGER, '18', null, XMLDB_NOTNULL, null, null);
        $table->add_field('hideingradebook', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, null);
        $table->add_field('mandatory', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table format_fntabs_cm.
        $table->add_key('id', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table format_fntabs_cm.
        $table->add_index('mdl_formnedtabscm_cou_ix', XMLDB_INDEX_NOTUNIQUE, array('courseid'));
        $table->add_index('mdl_formnedtabscm_cmi_ix', XMLDB_INDEX_NOTUNIQUE, array('cmid'));

        // Conditionally launch create table for format_fntabs_cm.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table format_fntabs_config to be created.
        $table = new xmldb_table('format_fntabs_config');

        // Adding fields to table format_fntabs_config.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '18', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '18', null, XMLDB_NOTNULL, null, null);
        $table->add_field('variable', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('value', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);

        // Adding keys to table format_fntabs_config.
        $table->add_key('id', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table format_fntabs_config.
        $table->add_index('mdl_formnedtabsconf_cou_ix', XMLDB_INDEX_NOTUNIQUE, array('courseid'));

        // Conditionally launch create table for format_fntabs_config.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fntabs savepoint reached.
        upgrade_plugin_savepoint(true, 2016090600, 'format', 'fntabs');
    }
    return true;
}