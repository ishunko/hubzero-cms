<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright 2005-2019 HUBzero Foundation, LLC.
 * @license    http://opensource.org/licenses/MIT MIT
 */

namespace Plugins\Resources\Recommendations\Models;

use Hubzero\Database\Relational;

/**
 * Model class for resource Recommendation
 */
class Recommendation extends Relational
{
	/**
	 * The table to which the class pertains
	 *
	 * This will default to #__{namespace}_{modelName} unless otherwise
	 * overwritten by a given subclass. Definition of this property likely
	 * indicates some derivation from standard naming conventions.
	 *
	 * @var  string
	 */
	protected $table = '#__recommendation';

	/**
	 * Default order by for model
	 *
	 * @var  string
	 */
	public $orderBy = 'fromID';

	/**
	 * Default order direction for select queries
	 *
	 * @var  string
	 */
	public $orderDir = 'asc';

	/**
	 * Fields and their validation criteria
	 *
	 * @var  array
	 */
	protected $rules = array(
		'fromID' => 'positive|nonzero',
		'toID'   => 'positive|nonzero'
	);

	/**
	 * Retrieves records
	 *
	 * @param   integer  $id
	 * @param   float    $threshold
	 * @return  object
	 */
	public static function find($id, $threshold)
	{
		/*
		$query = "SELECT *, (10*titleScore + 5*contentScore+2*tagScore)/(10+5+2) AS rec_score
		FROM #__recommendation AS rec, #__resources AS r
		WHERE (rec.fromID ='".$id."' AND r.id = rec.toID AND r.standalone=1)
		OR (rec.toID ='".$id."' AND r.id = rec.fromID AND r.standalone=1 AND r.published=1) having rec_score > ".$threshold."
		ORDER BY rec_score DESC LIMIT ".$limit;
		*/

		$entries = self::all();

		$c = $entries->getTableName();
		$r = '#__resources';

		return $entries
			->select($r . '.*')
			->select('(10*titleScore + 5*contentScore+2*tagScore)/(10+5+2) AS rec_score')
			->join($r, $r . '.id', $c . '.fromID')
			->whereEquals($r . '.standalone', 1)
			->whereEquals($r . '.published', 1)
			->whereEquals($c . '.fromID', $id)
			->having('rec_score', '>', $threshold)
			->order('rec_score', 'desc');
	}
}
