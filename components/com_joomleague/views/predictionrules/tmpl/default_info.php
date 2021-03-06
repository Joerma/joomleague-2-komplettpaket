<?php 
/**
* @copyright	Copyright (C) 2007-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/



defined('_JEXEC') or die('Restricted access');
?><h3><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_01'); ?></h3>
<p><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_01_01'); ?></p>
<p><?php
		if ($this->actJoomlaUser->id < 62)
		{
			echo JText::sprintf('COM_JOOMLEAGUE_PRED_RULES_INFO_01_02','<a href="index.php?option=com_user&view=register"><b><i>','</i></b></a>');
		}
		else
		{
			if (!$this->predictionMember->pmID){echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_01_03');}
		}
		?></p>
<h3><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_02'); ?></h3>
<p><?php
	if ($this->predictionGame->auto_approve)
	{
		echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_02_01');
	}
	else
	{
		echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_02_02');
	}
	echo '<br />';
	echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_02_03');
	?></p>
<h3><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_03'); ?></h3>
<p><?php
	echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_03_01') . '<br />';
	if (!$this->predictionGame->admin_tipp)
	{
		echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_03_02');
	}
	else
	{
		echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_03_03');
	}
	?></p>
<h3><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_04'); ?></h3>
<p><?php  echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_04_01'); ?></p>
<p><?php  echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_04_02'); ?></p>
<h3><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_05'); ?></h3>
<p><?php  echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_05_01'); ?></p>
<?php
if ($this->config['show_points'])
{
	?>
	<p><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_05_02'); ?></p>
	<?php
	foreach ($this->model->_predictionProjectS AS $predictionProject)
	{
		if ($predictionProjectSettings = $this->model->getPredictionProject($predictionProject->project_id))
		{
			?>
			<table class='blog' cellpadding='0' cellspacing='0' border='1'>
				<tr>
					<td class='sectiontableheader' style='text-align:center; '><?php
						echo $predictionProjectSettings->name . ' - ';
						if ($predictionProject->mode=='0')
						{
							echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_05_STANDARD_MODE');
						}
						else
						{
							echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_05_TOTO_MODE');
						}
						?></td>
				</tr>
			</table>
			<table class='blog' cellpadding='0' cellspacing='0'>
				<tr>
					<td class='sectiontableheader' style='text-align:center; '><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_05_RESULT'); ?></td>
					<td class='sectiontableheader' style='text-align:center; '><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_05_YOUR_PREDICTION'); ?></td>
					<td class='sectiontableheader' style='text-align:center; '><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_05_POINTS'); ?></td>
					<?php
					if (($predictionProject->joker) && ($predictionProject->mode==0))
					{
						?><td class='sectiontableheader' style='text-align:center; '><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_05_JOKER_POINTS'); ?></td><?php
					}
					?>
				</tr>
				<tr class='sectiontableentry1'>
					<td class='info'><?php echo '2:1'; ?></td>
					<td class='info'><?php echo '2:1'; ?></td>
					<td class='info'><?php
						$result = $this->model->createResultsObject(2,1,1,2,1,0);
						echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
						?></td>
					<?php
					if (($predictionProject->joker) && ($predictionProject->mode==0))
					{
						?>
						<td class='info'><?php
							$result = $this->model->createResultsObject(2,1,1,2,1,1);
							echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
							?></td><?php
					}
					?>
				</tr>
				<tr class='sectiontableentry2'>
					<td class='info'><?php echo '2:1'; ?></td>
					<td class='info'><?php echo '3:2'; ?></td>
					<td class='info'><?php
						$result = $this->model->createResultsObject(2,1,1,3,2,0);
						echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
						?></td>
					<?php
					if (($predictionProject->joker) && ($predictionProject->mode==0))
					{
						?>
						<td class='info'><?php
							$result = $this->model->createResultsObject(2,1,1,3,2,1);
							echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
							?></td><?php
					}
					?>
				</tr>
				<tr class='sectiontableentry1'>
					<td class='info'><?php echo '1:1'; ?></td>
					<td class='info'><?php echo '2:2'; ?></td>
					<td class='info'><?php
						$result = $this->model->createResultsObject(1,1,0,2,2,0);
						echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
						?></td>
					<?php
					if (($predictionProject->joker) && ($predictionProject->mode==0))
					{
						?>
						<td class='info'><?php
							$result = $this->model->createResultsObject(1,1,0,2,2,1);
							echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
							?></td><?php
					}
					?>
				</tr>
				<tr class='sectiontableentry2'>
					<td class='info'><?php echo '1:2'; ?></td>
					<td class='info'><?php echo '1:3'; ?></td>
					<td class='info'><?php
						$result = $this->model->createResultsObject(1,2,1,1,3,0);
						echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
						?></td>
					<?php
					if (($predictionProject->joker) && ($predictionProject->mode==0))
					{
						?>
						<td class='info'><?php
							$result = $this->model->createResultsObject(1,2,1,1,3,1);
							echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
							?></td><?php
					}
					?>
				</tr>
				<tr class='sectiontableentry1'>
					<td class='info'><?php echo '2:1'; ?></td>
					<td class='info'><?php echo '0:1'; ?></td>
					<td class='info'><?php
						$result = $this->model->createResultsObject(2,1,2,0,1,0);
						echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
						?></td>
					<?php
					if (($predictionProject->joker) && ($predictionProject->mode==0))
					{
						?>
						<td class='info'><?php
							$result = $this->model->createResultsObject(2,1,2,0,1,1);
							echo $this->model->getMemberPredictionPointsForSelectedMatch($predictionProject,$result);
							?></td><?php
					}
					?>
				</tr>
			</table>
			<?php
		}
	}
}
?>
<h3><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_06'); ?></h3>
<p><?php
	echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_06_01');
	?></p><ul><?php
	foreach ($this->model->_predictionProjectS AS $predictionProject)
	{
		if ($predictionProjectSettings = $this->model->getPredictionProject($predictionProject->project_id))
		{
			if ($predictionProject->champ > 0)
			{
				?><li><?php
					if ($predictionProject->overview)
					{
						echo JText::sprintf('COM_JOOMLEAGUE_PRED_RULES_TOPIC_06_HALF_SEASON',
												'<b>'.$predictionProject->points_tipp_champ.'</b>',
												'<b><i>'.$predictionProjectSettings->name.'</i></b>');
					}
					else
					{
						echo JText::sprintf(	'COM_JOOMLEAGUE_PRED_RULES_TOPIC_06_FULL_SEASON',
												'<b>'.$predictionProject->points_tipp_champ.'</b>',
												'<b><i>'.$predictionProjectSettings->name.'</i></b>');
					}
					?></li>
				<?php
			}
		}
	}
	?></ul>
<p><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_06_02'); ?></p>
<p><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_06_03'); ?></p>
<h3><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_07'); ?></h3>
<p><?php  echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_07_01'); ?></p>
<h3><?php echo JText::_('COM_JOOMLEAGUE_PRED_RULES_TOPIC_08'); ?></h3>
<p><?php  echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_08_01'); ?></p>
<p><?php  echo JText::_('COM_JOOMLEAGUE_PRED_RULES_INFO_08_02'); ?></p>
<br />