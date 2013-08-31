<?php

/**
 * @copyright	Copyright (C) 2006-2013 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
require_once (JPATH_COMPONENT . DS . 'models' . DS . 'list.php');

/**
 * Joomleague Component Seasons Model
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueModelLeagues extends JoomleagueModelList
{
    var $_identifier = "leagues";

    function _buildQuery()
    {
        // Get the WHERE and ORDER BY clauses for the query
        $where = $this->_buildContentWhere();
        $orderby = $this->_buildContentOrderBy();
        // Create a new query object.
        $query = $this->_db->getQuery(true);
        $query->select(array('obj.*', 'u.name AS editor'))
        ->from('#__joomleague_league AS obj')
        ->join('LEFT', '#__users AS u ON u.id = obj.checked_out');

        if ($where)
        {
            $query->where($where);
        }
        if ($orderby)
        {
            $query->order($orderby);
        }

        return $query;
    }

    function _buildContentOrderBy()
    {
        $option = JRequest::getCmd('option');
        $mainframe = JFactory::getApplication();
        $filter_order = $mainframe->getUserStateFromRequest($option . 'l_filter_order',
            'filter_order', 'obj.ordering', 'cmd');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option .
            'l_filter_order_Dir', 'filter_order_Dir', '', 'word');
        if ($filter_order == 'obj.ordering')
        {
            $orderby = 'obj.ordering ' . $filter_order_Dir;
        } else
        {
            $orderby = '' . $filter_order . ' ' . $filter_order_Dir . ',obj.ordering ';
        }
        return $orderby;
    }

    function _buildContentWhere()
    {
        $option = JRequest::getCmd('option');
        $mainframe = JFactory::getApplication();
        $filter_order = $mainframe->getUserStateFromRequest($option . 'l_filter_order',
            'filter_order', 'obj.ordering', 'cmd');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option .
            'l_filter_order_Dir', 'filter_order_Dir', '', 'word');
        $search = $mainframe->getUserStateFromRequest($option . 'l_search', 'search', '',
            'string');
        $search = JString::strtolower($search);
        $where = array();
        if ($search)
        {
            $where[] = 'LOWER(obj.name) LIKE ' . $this->_db->Quote('%' . $search . '%');
        }
        $where = (count($where) ? '' . implode(' AND ', $where) : '');
        return $where;
    }

    /**
     * Method to return a leagues array (id,name)
     *
     * @access	public
     * @return	array seasons
     * @since	1.5.0a
     */
    function getLeagues()
    {
        // Get a db connection.
        $db = JFactory::getDBO();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query->select(array('id', 'name'))
        ->from('#__joomleague_league')
        ->order('name ASC');

        $db->setQuery($query);
        if (!$result = $db->loadObjectList())
        {
            $this->setError($db->getErrorMsg());
            return array();
        }
        foreach ($result as $league)
        {
            $league->name = JText::_($league->name);
        }
        return $result;
    }
}

?>