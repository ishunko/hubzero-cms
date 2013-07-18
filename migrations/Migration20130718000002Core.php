<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * Migration script for migrating joomla content
 **/
class Migration20130718000002Core extends Hubzero_Migration
{
	/**
	 * Up
	 **/
	protected static function up($db)
	{
		// Create assets table (all of this will only run the first time the table is created)
		if (!$db->tableExists('#__assets'))
		{
			$query = "CREATE  TABLE IF NOT EXISTS `#__assets` (
				`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
				`parent_id` INT(11) NOT NULL DEFAULT '0' ,
				`lft` INT(11) NOT NULL DEFAULT '0' ,
				`rgt` INT(11) NOT NULL DEFAULT '0' ,
				`level` INT(10) UNSIGNED NOT NULL ,
				`name` VARCHAR(50) NOT NULL ,
				`title` VARCHAR(100) NOT NULL ,
				`rules` VARCHAR(5120) NOT NULL ,
				PRIMARY KEY (`id`) ,
				UNIQUE INDEX `idx_asset_name` (`name` ASC) ,
				INDEX `idx_lft_rgt` (`lft` ASC, `rgt` ASC) ,
				INDEX `idx_parent_id` (`parent_id` ASC) )
			ENGINE = InnoDB
			DEFAULT CHARACTER SET = utf8
			COLLATE = utf8_general_ci;";

			$db->setQuery($query);
			$db->query();

			// Insert some default values
			$query = "INSERT INTO `#__assets` (`id`, `parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`)
			VALUES
				(1,0,0,0,0, 'root.1', 'Root Asset', '{\"core.login.site\":{\"6\":1,\"2\":1},\"core.login.admin\":{\"6\":1},\"core.admin\":{\"8\":1},\"core.manage\":{\"7\":1},\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),
				(2,1,0,0,1,'com_admin','com_admin','{}'),
				(3,1,0,0,1,'com_banners','com_banners','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),
				(4,1,0,0,1,'com_cache','com_cache','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),
				(5,1,0,0,1,'com_checkin','com_checkin','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),
				(6,1,0,0,1,'com_config','com_config','{}'),
				(7,1,0,0,1,'com_contact','com_contact','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),
				(8,1,0,0,1,'com_content','com_content','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1},\"core.edit.own\":[]}'),
				(9,1,0,0,1,'com_cpanel','com_cpanel','{}'),
				(10,1,0,0,1,'com_installer','com_installer','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1},\"core.delete\":[],\"core.edit.state\":[]}'),
				(11,1,0,0,1,'com_languages','com_languages','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),
				(12,1,0,0,1,'com_login','com_login','{}'),
				(13,1,0,0,1,'com_mailto','com_mailto','{}'),
				(14,1,0,0,1,'com_massmail','com_massmail','{}'),
				(15,1,0,0,1,'com_media','com_media','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":{\"5\":1}}'),
				(16,1,0,0,1,'com_menus','com_menus','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),
				(17,1,0,0,1,'com_messages','com_messages','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),
				(18,1,0,0,1,'com_modules','com_modules','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),
				(19,1,0,0,1,'com_newsfeeds','com_newsfeeds','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),
				(20,1,0,0,1,'com_plugins','com_plugins','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.edit\":[],\"core.edit.state\":[]}'),
				(21,1,0,0,1,'com_redirect','com_redirect','{\"core.admin\":{\"7\":1},\"core.manage\":[]}'),
				(22,1,0,0,1,'com_search','com_search','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),
				(23,1,0,0,1,'com_templates','com_templates','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),
				(24,1,0,0,1,'com_users','com_users','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.own\":{\"6\":1},\"core.edit.state\":[]}'),
				(25,1,0,0,1,'com_weblinks','com_weblinks','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1},\"core.edit.own\":[]}'),
				(26,1,0,0,1,'com_wrapper','com_wrapper','{}'),
				(27,8,0,0,2,'com_content.category.2', 'Uncategorised', '{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),
				(28,3,0,0,2,'com_banners.category.3', 'Uncategorised', '{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),
				(29,7,0,0,2,'com_contact.category.4', 'Uncategorised', '{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),
				(30,19,0,0,2,'com_newsfeeds.category.5', 'Uncategorised', '{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}'),
				(31,25,0,0,2,'com_weblinks.category.6', 'Uncategorised', '{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[],\"core.edit.own\":[]}');";

			$db->setQuery($query);
			$db->query();

			// Insert all components as assets (parent is 0 because we don't need more than 1 entry per component - i.e. no sub items used for menus in 1.5)
			$db->setQuery('SELECT * FROM `#__components` WHERE parent = 0');
			$components = $db->loadObjectList();

			if (count($components) > 0)
			{
				// Build default ruleset
				$defaulRules = array(
					"core.admin"      => array(
						"7" => 1
						),
					"core.manage"     => array(
						"6" => 1
						),
					"core.create"     => array(),
					"core.delete"     => array(),
					"core.edit"       => array(),
					"core.edit.state" => array()
					);

				// Craft query
				$componentsInsert = "INSERT INTO `#__assets` (`parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`) VALUES ";
				foreach ($components as $com)
				{
					// Make sure it isn't already in there
					$query = "SELECT id FROM `#__assets` WHERE `name` = " . $db->Quote($com->option);
					$db->setQuery($query);
					if ($db->loadResult())
					{
						continue;
					}

					$values = "(";
					$values .= '1,';                                  // parent_id 1 is the root asset
					$values .= $db->Quote('') . ',';                  // lft
					$values .= $db->Quote('') . ',';                  // rgt
					$values .= '1,';                                  // level
					$values .= $db->Quote($com->option) . ',';        // name
					$values .= $db->Quote($com->option) . ',';        // title
					$values .= $db->Quote(json_encode($defaulRules)); // rules
					$values .= ")";
					$q[]     = $values;
				}
				$componentsInsert .= implode(',', $q) . ";";
				$db->setQuery($componentsInsert);
				$db->query();
				$q = array();
			}

			// Insert existing categories as assets (ignore root item)
			$db->setQuery('SELECT * FROM `#__categories` WHERE extension != "system"');
			$categories = $db->loadObjectList();

			if (count($categories) > 0)
			{
				foreach ($categories as $cat)
				{
					// Make sure it isn't already in there
					$query = "SELECT id FROM `#__assets` WHERE `name` = " . $db->Quote($cat->extension.'.category.'.$cat->id);
					$db->setQuery($query);
					if ($db->loadResult())
					{
						continue;
					}

					// Query for parent id
					$query = "SELECT `id` FROM `#__assets` WHERE `name` = " . $db->Quote($cat->extension);
					$db->setQuery($query);
					$result = $db->loadResult();
					$result = (is_numeric($result)) ? $result : '';

					$query  = "INSERT INTO `#__assets` (`parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`) VALUES (";
					$query .= $db->Quote($result) . ',';                                                             // parent_id (from list entered above)
					$query .= $db->Quote('') . ',';                                                                  // lft
					$query .= $db->Quote('') . ',';                                                                  // rgt
					$query .= $cat->level+1 . ',';                                                                   // level
					$query .= $db->Quote($cat->extension.'.category.'.$cat->id) . ',';                               // name
					$query .= $db->Quote($cat->extension) . ',';                                                     // title
					$query .= $db->Quote('{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'); // rules
					$query .= ");";
					$db->setQuery($query);
					$db->query();

					// Now, update the categories table with the asset id
					$id = $db->insertid();
					$query = "UPDATE `#__categories` SET `asset_id` = {$id} WHERE `id` = {$cat->id};";
					$db->setQuery($query);
					$db->query();
				}
			}

			// Now, go back and set parent_id for categories that are level 2 (those were original 1.5 categories, i.e. below sections)
			$query = "SELECT * FROM `#__categories` WHERE level = 2";
			$db->setQuery($query);
			$results = $db->loadObjectList();

			if (count($results) > 0)
			{
				foreach ($results as $r)
				{
					// Get the category id from the assets table
					$query = "SELECT `id` FROM `#__assets` WHERE name = " . $db->Quote('com_content.category.'.$r->id);
					$db->setQuery($query);
					$id = $db->loadResult();

					// Get the category parent id from the assets table
					$query = "SELECT `id` FROM `#__assets` WHERE name = " . $db->Quote('com_content.category.'.$r->parent_id);
					$db->setQuery($query);
					$parent_id = $db->loadResult();

					// Update the assets table
					$query = "UPDATE `#__assets` SET parent_id = {$parent_id} WHERE `id` = {$id}";
					$db->setQuery($query);
					$db->query();
				}
			}

			// We're going to go ahead and add asset_id here, as we need to insert into below
			if (!$db->tableHasField('#__content', 'asset_id') && $db->tableHasField('#__content', 'id'))
			{
				$query = "ALTER TABLE `#__content` ADD COLUMN `asset_id` INTEGER UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to the #_assets table.' AFTER `id`;";
				$db->setQuery($query);
				$db->query();
			}

			// Insert articles
			$db->setQuery('SELECT * FROM `#__content`');
			$articles = $db->loadObjectList();

			if (count($articles) > 0)
			{
				foreach ($articles as $art)
				{
					// Query for parent ID
					$query = "SELECT `id`, `level` FROM `#__assets` WHERE `name` = " . $db->Quote('com_content.category.'.$art->catid);
					$db->setQuery($query);
					$obj    = $db->loadObject();
					$result = (is_object($obj) && is_numeric($obj->id))    ? $obj->id      : '';
					$level  = (is_object($obj) && is_numeric($obj->level)) ? $obj->level+1 : 4;

					// Set parent id of "uncategorised" articles
					if ($art->catid == "0")
					{
						$result = 27;
					}

					$query  = "INSERT INTO `#__assets` (`parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`) VALUES (";
					$query .= $db->Quote($result) . ',';                                            // parent_id
					$query .= $db->Quote('') . ',';                                                 // lft
					$query .= $db->Quote('') . ',';                                                 // rgt
					$query .= $level . ',';                                                         // level
					$query .= $db->Quote('com_content.article.'.$art->id) . ',';                    // name
					$query .= $db->Quote($art->title) . ',';                                        // title
					$query .= $db->Quote('{"core.delete":[],"core.edit":[],"core.edit.state":[]}'); // rules
					$query .= ")";
					$db->setQuery($query);
					$db->query();

					// Now, update the content table with the asset id
					$id = $db->insertid();
					$query = "UPDATE `#__content` SET `asset_id` = {$id} WHERE `id` = {$art->id};";
					$db->setQuery($query);
					$db->query();
				}
			}

			// Rule set for super admins only
			$rules = array(
				"core.admin"      => array(
					"7" => 1
					),
				"core.manage"     => array(
					"7" => 1
					),
				"core.create"     => array(
					"7" => 1
					),
				"core.delete"     => array(
					"7" => 1
					),
				"core.edit"       => array(
					"7" => 1
					),
				"core.edit.state" => array(
					"7" => 1
					)
				);
			$db->setQuery("UPDATE `#__assets` SET rules='".json_encode($rules)."' WHERE NAME= 'com_mailto' OR NAME='com_massmail' OR NAME='com_config';");
			$db->query();

			// If we have the nested set class available, use it to rebuild lft/rgt
			if (class_exists('JTableNested') && method_exists('JTableNested', 'rebuild'))
			{
				// Rebuild categories
				// Use the MySQL driver for this
				$config = JFactory::getConfig();
				$database = JDatabase::getInstance(
					array(
						'driver'   => 'mysql',
						'host'     => $config->getValue('host'),
						'user'     => $config->getValue('user'),
						'password' => $config->getValue('password'),
						'database' => $config->getValue('db')
					) 
				);

				$table = new JTableCategory($database);
				$table->rebuild();

				// Rebuild assets
				self::rebuildAssets();
			}
		}
	}

	private function rebuildAssets($parentId=0, $leftId=0, $level=0)
	{
		$database = JFactory::getDbo();
		$query = $database->getQuery(true);
		$query->select('id');
		$query->from('#__assets');
		$query->where('parent_id = %d');
		$query->order('parent_id, lft');
		$database->setQuery(sprintf($query, (int) $parentId));
		$children = $database->loadObjectList();

		$rightId = $leftId + 1;

		foreach ($children as $node)
		{
			$rightId = self::rebuildAssets($node->id, $rightId, $level + 1);

			if ($rightId === false)
			{
				return false;
			}
		}

		$query = $database->getQuery(true);
		$query->update('#__assets');
		$query->set('lft = ' . (int) $leftId);
		$query->set('rgt = ' . (int) $rightId);
		$query->set('level = ' . (int) $level);
		$query->where('id = ' . (int) $parentId);
		$database->setQuery($query);
		$database->execute();

		return $rightId + 1;
	}
}