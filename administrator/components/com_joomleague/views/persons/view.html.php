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

jimport('joomla.application.component.view');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewPersons extends JLGView
{

	function display($tpl=null)
	{
		if ($this->getLayout() == 'assignplayers')
		{
			$this->_displayAssignPlayers($tpl);
			return;
		}
		$option = JRequest::getCmd('option');
		$mainframe = JFactory::getApplication();
		
		$model	= $this->getModel();

		$filter_state		= $mainframe->getUserStateFromRequest($option.'pl_filter_state', 'filter_state', '', 'word');
		$filter_order		= $mainframe->getUserStateFromRequest($option.'pl_filter_order', 'filter_order', 'pl.ordering', 'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'pl_filter_order_Dir', 'filter_order_Dir', '', 'word');
		$search				= $mainframe->getUserStateFromRequest($option.'pl_search', 'search', '', 'string');
		$search_mode		= $mainframe->getUserStateFromRequest($option.'pl_search_mode', 'search_mode', '', 'string');
        $filter_info		= $mainframe->getUserStateFromRequest($option.'pl_filter_info', 'filter_info', '', 'string');

		$items =& $this->get('Data');
		$total =& $this->get('Total');
		$pagination =& $this->get('Pagination');

		$mainframe->setUserState($option.'task','');

		// state filter
		$lists['state']=JHTML::_('grid.state',$filter_state);

		// table ordering
		$lists['order_Dir']=$filter_order_Dir;
		$lists['order']=$filter_order;

		// search filter
		$lists['search']=$search;
		$lists['search_mode']=$search_mode;

		//build the html select list for positions
		$positionsList[]=JHTML::_('select.option','0',JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_POSITION'));
		$positions=JModel::getInstance('person','joomleaguemodel')->getPositions();
		if ($positions){ $positions=array_merge($positionsList,$positions);}
		$lists['positions']=$positions;
		unset($positionsList);

		//build the html options for nation
		$nation[]=JHTML::_('select.option','0',JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_NATION'));
		if ($res =& Countries::getCountryOptions()){$nation=array_merge($nation,$res);}
		$lists['nation']=$nation;
		unset($nation);

		$this->assignRef('user',JFactory::getUser());
		$this->assignRef('config',JFactory::getConfig());
		$this->assignRef('lists',$lists);
		$this->assignRef('items',$items);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('request_url',JFactory::getURI()->toString());
		$this->addToolbar();
		parent::display($tpl);
	}

	function _displayAssignPlayers($tpl=null)
	{
		$option = JRequest::getCmd('option');
		$mainframe = JFactory::getApplication();
		$model = $this->getModel();
		$project_id = $mainframe->getUserState($option.'project');
		$mdlProject = JModel::getInstance("project", "JoomLeagueModel");
		$project_name = $mdlProject->getProjectName($project_id);
		$project_team_id = $mainframe->getUserState($option.'project_team_id');
		$team_name = $model->getProjectTeamName($project_team_id);
		$mdlQuickAdd =& JLGModel::getInstance('Quickadd','JoomleagueModel');

		$filter_state		= $mainframe->getUserStateFromRequest($option.'pl_filter_state', 'filter_state', '', 'word');
		$filter_order		= $mainframe->getUserStateFromRequest($option.'pl_filter_order', 'filter_order', 'pl.ordering',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'pl_filter_order_Dir', 'filter_order_Dir', '', 'word');
		$search			= $mainframe->getUserStateFromRequest($option.'pl_search', 'search', '', 'string');
		$search_mode		= $mainframe->getUserStateFromRequest($option.'pl_search_mode',	'search_mode', '', 'string');
        $filter_info		= $mainframe->getUserStateFromRequest($option.'pl_filter_info', 'filter_info', '', 'string');
        

		//save icon should be replaced by the apply
		JLToolBarHelper::apply('person.saveassigned',JText::_('COM_JOOMLEAGUE_ADMIN_PERSONS_SAVE_SELECTED'));		
		
		// Set toolbar items for the page
		$type=JRequest::getInt('type');
		if ($type==0)
		{
                    //back icon should be replaced by the abort/close icon
                    JToolBarHelper::back(JText::_('COM_JOOMLEAGUE_ADMIN_PERSONS_BACK'),'index.php?option=com_joomleague&task=teamplayer.display&view=teamplayers');
                    JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_PERSONS_ASSIGN_PLAYERS'),'generic.png');
                    $items = $mdlQuickAdd->getNotAssignedPlayers(JString::strtolower($search),$project_team_id,$filter_info);
		}
		elseif ($type==1)
		{
                    //back icon should be replaced by the abort/close icon
                    JToolBarHelper::back(JText::_('COM_JOOMLEAGUE_ADMIN_PERSONS_BACK'),'index.php?option=com_joomleague&task=teamstaff.display&view=teamstaffs');
                    JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_PERSONS_ASSIGN_STAFF'),'generic.png');
                    $items = $mdlQuickAdd->getNotAssignedStaff(JString::strtolower($search),$project_team_id,$filter_info);
		}
		elseif ($type==2)
		{
                    //back icon should be replaced by the abort/close icon
                    JToolBarHelper::back(JText::_('COM_JOOMLEAGUE_ADMIN_PERSONS_BACK'),'index.php?option=com_joomleague&view=projectreferees&task=projectreferee.display');
                    JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_PERSONS_ASSIGN_REFEREES'),'generic.png');
                    $items = $mdlQuickAdd->getNotAssignedReferees(JString::strtolower($search),$project_id,$filter_info);
		}

		JLToolBarHelper::onlinehelp();		
		
		$limit = $mainframe->getUserStateFromRequest('global.list.limit','limit',$mainframe->getCfg('list_limit'),'int');

		
        
        //build the html select list for info field
		$infoList[]=JHtml::_('select.option','',JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_INFO_FIELD'),'id','name');
		$infos = JModel::getInstance('person','JoomleagueModel');
		$allInfos = $infos->getInfofield();
        if ( $allInfos )
        {
		$infoList=array_merge($infoList,$allInfos);
		$lists['infofield']=JHtml::_( 'select.genericList',
									$infoList,
									'filter_info',
									'class="inputbox" onChange="this.form.submit();" style="width:120px"',
									'id',
									'name',
									$filter_info);
		unset($infoList);
        }
        
        jimport('joomla.html.pagination');
		$pagination = new JPagination($mdlQuickAdd->_total,JRequest::getVar('limitstart',0,'','int'),$limit);
		$mdlQuickAdd->_pagination=$pagination;

		// table ordering
		$lists['order_Dir']=$filter_order_Dir;
		$lists['order']=$filter_order;

		// search filter
		$lists['search']=$search;
		$lists['search_mode']=$search_mode;

		$this->assignRef('prjid',$project_id);
		$this->assignRef('prj_name',$project_name);
		$this->assignRef('team_id',$team_id);
		$this->assignRef('team_name',$team_name);
		$this->assignRef('project_team_id',$project_team_id);
		$this->assignRef('lists',$lists);
		$this->assignRef('items',$items);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('request_url',JFactory::getURI()->toString());
		$this->assignRef('type',$type);

		parent::display($tpl);
	}

	/**
	 * Displays a calendar control field with optional onupdate js handler
	 *
	 * @param	string	The date value
	 * @param	string	The name of the text field
	 * @param	string	The id of the text field
	 * @param	string	The date format
	 * @param	string	js function to call on date update
	 * @param	array	Additional html attributes
	 */
	function calendar($value,$name,$id,$format='%Y-%m-%d',$attribs=null,$onUpdate=null,$i=null)
	{
		JHTML::_('behavior.calendar'); //load the calendar behavior

		if (is_array($attribs)){$attribs=JArrayHelper::toString($attribs);}
		$document = JFactory::getDocument();
		$document->addScriptDeclaration('window.addEvent(\'domready\',function() {Calendar.setup({
	        inputField     :    "'.$id.'",    // id of the input field
	        ifFormat       :    "'.$format.'",     // format of the input field
	        button         :    "'.$id.'_img", // trigger for the calendar (button ID)
	        align          :    "Tl",          // alignment (defaults to "Bl")
	        onUpdate       :    '.($onUpdate ? $onUpdate : 'null').',
	        singleClick    :    true
    	});});');
		$html='';
		$html .= '<input onchange="document.getElementById(\'cb'.$i.'\').checked=true" type="text" name="'.$name.'" id="'.$id.'" value="'.htmlspecialchars($value,ENT_COMPAT,'UTF-8').'" '.$attribs.' />'.
				 '<img class="calendar" src="'.JURI::root(true).'/templates/system/images/calendar.png" alt="calendar" id="'.$id.'_img" />';
		return $html;
	}
	
	/**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{
		// Set toolbar items for the page
		JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_PERSONS_TITLE'),'user');

		JLToolBarHelper::publishList('person.publish');
		JLToolBarHelper::unpublishList('person.unpublish');
		JToolBarHelper::divider();
		JLToolBarHelper::apply('person.saveshort');
		JLToolBarHelper::editList('person.edit');
		JLToolBarHelper::addNew('person.add');
		JLToolBarHelper::custom('person.import','upload','upload',JText::_('COM_JOOMLEAGUE_GLOBAL_CSV_IMPORT'),false);
		JLToolBarHelper::archiveList('person.export',JText::_('COM_JOOMLEAGUE_GLOBAL_XML_EXPORT'));
		JLToolBarHelper::deleteList(JText::_('COM_JOOMLEAGUE_ADMIN_PERSONS_DELETE_WARNING'),'person.remove');
		JToolBarHelper::divider();
		JLToolBarHelper::onlinehelp();
		JToolBarHelper::preferences(JRequest::getCmd('option'));
	}
}
?>