<?php
/* Copyright (C) 2022 SuperAdmin
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    voyagebuilder/class/actions_voyagebuilder.class.php
 * \ingroup voyagebuilder
 * \brief   Example hook overload.
 *
 * Put detailed description here.
 */

/**
 * Class ActionsVoyageBuilder
 */
class ActionsVoyageBuilder
{
	/**
	 * @var DoliDB Database handler.
	 */
	public $db;

    /**
	 * Constructor
	 *
	 *  @param		DoliDB		$db      Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}


    public function addMoreActionsButtons($parameters, &$object, &$action, $hookmanager)
    {

        global $conf, $db, $langs ;

        $object->fetchObjectLinked(null, '', null, 'voyagebuilder');

        if (in_array('productcard', explode(':', $parameters['context'])) && $object->type == Product::TYPE_PRODUCT && !($object->linkedObjectsIds))
        {
            print '<a class="butAction" id="HookCreateVoyage" href="'.DOL_URL_ROOT .'/custom/voyagebuilder/voyage_card.php?action=create&options_product='.$object->id.'">'.$langs->trans("CreateVoyage").'</a>'."\n";
        }

        return 0;
    }

}
