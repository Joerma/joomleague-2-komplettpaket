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
 * @since	1.5
 */
class JoomleagueViewPerson extends JLGView
{
	function display($tpl=null)
	{
		$mainframe = JFactory::getApplication();

		if ($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}
		elseif ($this->getLayout() == 'assignperson')
		{
			$this->_displayModal($tpl);
			return;
		}
	}

	function _displayForm($tpl)
	{
		$option = JRequest::getCmd('option');
		$mainframe = JFactory::getApplication();
        $document	= JFactory::getDocument();
		$db = JFactory::getDBO();
		$uri = JFactory::getURI();
		$user = JFactory::getUser();
		$model = $this->getModel();
		$edit=JRequest::getVar('edit',true);
        
        //$mainframe->enqueueMessage(JText::_('view -> '.'<pre>'.print_r(JRequest::getVar('view'),true).'</pre>' ),'');
		
		$this->assign('cfg_which_media_tool', JComponentHelper::getParams($option)->get('cfg_which_media_tool',0) );
            
		$lists=array();

		//get the person
		$person =& $this->get('data');
		$isNew=($person->id < 1);

    // fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_THEPERSON'),$person->name);
			$mainframe->redirect('index.php?option='.$option,$msg);
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout($user->get('id'));
		}
		else
		{
			$person->ordering=0;
		}

		$this->assignRef('form'      	, $this->get('form'));
        	
		$this->assignRef('edit',$edit);
		$extended = $this->getExtended($person->extended, 'person');		
		$this->assignRef( 'extended', $extended );
        $form_value = $this->extended->getValue('COM_JOOMLEAGUE_EXT_PERSON_PARENT_POSITIONS');
        //$mainframe->enqueueMessage(JText::_('form_value -> '.'<pre>'.print_r($form_value,true).'</pre>' ),'');
        if ( $form_value )
        {
            $this->extended->setValue('COM_JOOMLEAGUE_EXT_PERSON_PARENT_POSITIONS', null,explode(",",$form_value));
        }
		
        $this->assignRef( 'checkextrafields', $model->checkUserExtraFields() );
        if ( $this->checkextrafields )
        {
            $lists['ext_fields'] = $model->getUserExtraFields($person->id);
            //$mainframe->enqueueMessage(JText::_('view -> '.'<pre>'.print_r($lists['ext_fields'],true).'</pre>' ),'');
        }
        
        $this->assignRef('lists',$lists);
		$this->assignRef('person',$person);
        
        $document->addStyleSheet( JURI::root(). '/components/'.$option.'/assets/css/player.css' );

		$this->addToolbar();			
		parent::display($tpl);
	}

	function _displayModal($tpl)
	{
		$mainframe	= JFactory::getApplication();

		// Do not allow cache
		JResponse::allowCache(false);

		$document = JFactory::getDocument();
		$prjid=array();
		$prjid=JRequest::getVar('prjid',array(0),'post','array');
		$proj_id=(int) $prjid[0];

		//build the html select list for projects
		$projects[]=JHTML::_('select.option','0',JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_PROJECT'),'id','name');

		if ($res=JoomleagueHelper::getProjects()){$projects=array_merge($projects,$res);}
		$lists['projects']=JHTMLSelect::genericlist(	$projects,
														'prjid[]',
														'class="inputbox" onChange="this.form.submit();" style="width:170px"',
														'id',
														'name',
														$proj_id);
		unset($projects);

		$projectteams[]=JHTMLSelect::option('0',JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_TEAM'),'value','text');

		// if a project is active we show the teams select list
		if ($proj_id > 0)
		{
			if ($res=JoomleagueHelper::getProjectteams($proj_id)){$projectteams=array_merge($projectteams,$res);}
			$lists['projectteams']=JHTMLSelect::genericlist($projectteams,'xtid[]','class="inputbox" style="width:170px"','value','text');
			unset($projectteams);
		}

		$this->assignRef('lists',$lists);
		$this->assignRef('project_id',$proj_id);

		parent::display($tpl);
	}
	/**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{	
		// Set toolbar items for the page
		$text = !$this->edit ? JText::_('COM_JOOMLEAGUE_GLOBAL_NEW') : JText::_('COM_JOOMLEAGUE_GLOBAL_EDIT');

		JLToolBarHelper::save('person.save');

		if (!$this->edit)
		{
			JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_TITLE'));
			JToolBarHelper::divider();
			JLToolBarHelper::cancel('person.cancel');
		}
		else
		{
			// for existing items the button is renamed `close` and the apply button is showed
			JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_TITLE2'));
			JLToolBarHelper::apply('person.apply');
			JToolBarHelper::divider();
			JLToolBarHelper::cancel('person.cancel',JText::_('COM_JOOMLEAGUE_GLOBAL_CLOSE'));
		}
		JToolBarHelper::divider();
		JToolBarHelper::back();
		JLToolBarHelper::onlinehelp();
	}		

}
?>