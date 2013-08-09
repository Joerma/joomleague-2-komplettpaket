<?php defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');JHTML::_('behavior.modal');
jimport('joomla.html.pane');

JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_TREETOMATCH_TITLE'));

//JLToolBarHelper::save();
JLToolBarHelper::custom('treetomatch.editlist','upload.png','upload_f2.png',JText::_('COM_JOOMLEAGUE_ADMIN_TREETOMATCH_BUTTON_ASSIGN'),false);
JToolBarHelper::back('Back','index.php?option=com_joomleague&view=treetonodes&task=treetonode.display');

JLToolBarHelper::onlinehelp();
?>

	<fieldset class="adminform">
		<legend><?php echo JText::sprintf('COM_JOOMLEAGUE_ADMIN_MATCHES_TITLE','<i>'.$this->nodews->node.'</i>','<i>'.$this->projectws->name.'</i>'); ?></legend>
		<!-- Start games list -->
		<form action="<?php echo $this->request_url; ?>" method="post" id='adminForm'>
			<?php
			$colspan= 9;
			?>
			<table class='adminlist' border='0'>
				<thead>
					<tr>
						<th width="5" style="vertical-align: top; "><?php echo count($this->match).'/'.$this->pagination->total; ?></th>
						<th width="20" style="vertical-align: top; "><?php echo JTEXT::_('COM_JOOMLEAGUE_ADMIN_MATCHES_MATCHNR'); ?></th>
						<th width="20" style="vertical-align: top; "><?php echo JTEXT::_('COM_JOOMLEAGUE_ADMIN_ROUNDS_ROUND_NR'); ?></th>
						<th class="title" nowrap="nowrap" style="vertical-align: top; "><?php echo JTEXT::_('COM_JOOMLEAGUE_ADMIN_MATCHES_HOME_TEAM'); ?></th>
						<th style="text-align: center; vertical-align: top; "><?php echo JTEXT::_('COM_JOOMLEAGUE_ADMIN_MATCHES_RESULT'); ?></th>
						<th class="title" nowrap="nowrap" style="vertical-align: top; "><?php echo JTEXT::_('COM_JOOMLEAGUE_ADMIN_MATCHES_AWAY_TEAM'); ?></th>
						<th width="1%" nowrap="nowrap" style="vertical-align: top; "><?php echo JTEXT::_('COM_JOOMLEAGUE_GLOBAL_PUBLISHED'); ?></th>
						<th width="1%" nowrap="nowrap" style="vertical-align: top; "><?php echo JTEXT::_('JGRID_HEADING_ID'); ?></th>
					</tr>
				</thead>
				<tfoot><tr><td colspan="<?php echo $colspan; ?>"><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>				
				<tbody>
					<?php
					$k=0;
					for ($i=0,$n=count($this->match); $i < $n; $i++)
					{
						$row		=& $this->match[$i];
						$checked	= JHTML::_('grid.checkedout',$row,$i,'mid');
						$published	= JHTML::_('grid.published',$row,$i,'tick.png','publish_x.png','treetomatch.');
						?>
						<tr class="<?php echo "row$k"; ?>">
					
							<td style="text-align:center; ">
								<?php
								echo $checked;
								?>
							</td>
							<td style="text-align: center; " nowrap="nowrap">
								<?php
								echo $row->matchnumber;
								?>
							</td>
							<td style="text-align: center; " class="nowrap">
								<?php
								echo $row->roundcode;
								?>
							</td>
							<td style="text-align: center; " class="nowrap">
								<?php
								echo $row->projectteam1;
								?>
							</td>
							<td style="text-align:center; ">
								<?php
								echo $row->projectteam1result;
								echo ' : ';
								echo $row->projectteam2result;
								?>
							</td>
							<td style="text-align: center; " class="nowrap">
								<?php
								echo $row->projectteam2;
								?>
							</td>
							<td style="text-align:center; ">
								<?php
								echo $published;
								?>
							</td>
							<td style="text-align:center; ">
								<?php
								echo $row->mid;
								?>
							</td>
						</tr>
						<?php
						$k=1 - $k;
					}
					?>
				</tbody>
			</table>
			<input type='hidden' name='boxchecked' value='0' />
			<input type='hidden' name='act' value='' />
			<input type='hidden' name='task' value='' id='task' />
			<?php echo JHTML::_('form.token')."\n"; ?>
		</form>
	</fieldset>