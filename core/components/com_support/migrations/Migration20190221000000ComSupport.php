<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright 2005-2019 HUBzero Foundation, LLC.
 * @license    http://opensource.org/licenses/MIT MIT
 */

use Hubzero\Content\Migration\Base;

// No direct access
defined('_HZEXEC_') or die();

/**
 * Migration script for changing DATETIME fields default to NULL for com_support
 **/
class Migration20190221000000ComSupport extends Base
{
	/**
	 * List of tables and their datetime fields
	 *
	 * @var  array
	 **/
	public static $tables = array(
		'#__support_attachments' => array(
			'created'
		),
		'#__support_categories' => array(
			'created',
			'modified'
		),
		'#__support_comments' => array(
			'created'
		),
		'#__support_queries' => array(
			'created'
		),
		'#__support_query_folders' => array(
			'created',
			'modified'
		),
		'#__support_tickets' => array(
			'created',
			'closed'
		)
	);

	/**
	 * Up
	 **/
	public function up()
	{
		foreach (self::$tables as $table => $fields)
		{
			foreach ($fields as $field)
			{
				if ($this->db->tableExists($table)
				 && $this->db->tableHasField($table, $field))
				{
					$query = "ALTER TABLE `$table` CHANGE `$field` `$field` DATETIME  NULL  DEFAULT NULL";

					$this->db->setQuery($query);
					$this->db->query();

					$query = "UPDATE `$table` SET `$field`=NULL WHERE `$field`='0000-00-00 00:00:00'";

					$this->db->setQuery($query);
					$this->db->query();
				}
			}
		}
	}

	/**
	 * Down
	 **/
	public function down()
	{
		foreach (self::$tables as $table => $fields)
		{
			foreach ($fields as $field)
			{
				if ($this->db->tableExists($table)
				 && $this->db->tableHasField($table, $field))
				{
					$query = "ALTER TABLE `$table` CHANGE `$field` `$field` DATETIME  NOT NULL  DEFAULT '0000-00-00 00:00:00'";

					$this->db->setQuery($query);
					$this->db->query();
				}
			}
		}
	}
}
