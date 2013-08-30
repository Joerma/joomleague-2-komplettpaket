<?PHP

if ( $this->matchnumber )
{

//echo '<pre>',print_r($this->csv, true),'</pre>';

?>
<form action="<?php echo $this->request_url; ?>" method="post" id="adminForm">
<table id="<?php echo $dcsv['tableid']; ?>" class="table_from_csv_sortable<? if ($dcsv['sortable'] == false){ echo '_not';} ?>" width="<?php echo $dcsv['tablewidth']; ?>" border="<?php echo $dcsv['border']; ?>" cellspacing="<?php echo $dcsv['cellspacing']; ?>" cellpadding="<?php echo $dcsv['cellpadding']; ?>" bgcolor="<?php echo $dcsv['tablebgcolor']; ?>">
<tr>	
<th class="">Spielnummer</th>	
<th class="">Vorname</th>
<th class="">Nachname</th>
<th class="">In der Datenbank ?</th>
<th class="">Projektteam zugeordnet ?</th>
<th class="">Projektposition</th>
</tr>	
	
		<?php foreach ($this->csvplayers as $value): ?>
		<tr>
        <td><?php echo $value->nummer; ?></td>
        <td><?php echo $value->firstname; ?></td>
        <td><?php echo $value->lastname; ?></td>
        <?PHP
        if ( $value->person_id )
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/ok.png',
														'','title= "'.''.'"').'</td>';
        }
        else
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/error.png',
														'','title= "'.''.'"').'</td>';
        }
        
        if ( $value->project_person_id )
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/ok.png',
														'','title= "'.''.'"').'</td>';
        }
        else
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/error.png',
														'','title= "'.''.'"').'</td>';
        }
        
        ?>
        <td>
        <?php 
        //$inputappend = ' disabled="disabled"'; 
        $inputappend = '';
        if ( $value->project_position_id != 0 )
								{
									$selectedvalue = $value->project_position_id;
									$append = '';
								}
								else
								{
									$selectedvalue = 0;
									$append = ' style="background-color:#FFCCCC"';
								}
        if ( $value->project_position_id == 0 )
								{
									$append=' style="background-color:#FFCCCC"';
								}
								echo JHTML::_( 'select.genericlist', $this->lists['project_position_id'], 'project_position_id[' . $value->nummer.']', $inputappend . 'class="inputbox" size="1" onchange="document.getElementById(\'cb' . $i . '\').checked=true"' . $append, 'value', 'text', $selectedvalue );
        ?>
        </td>
        </tr>
		<?php endforeach; ?>
	
</table>

<table id="<?php echo $dcsv['tableid']; ?>" class="table_from_csv_sortable<? if ($dcsv['sortable'] == false){ echo '_not';} ?>" width="<?php echo $dcsv['tablewidth']; ?>" border="<?php echo $dcsv['border']; ?>" cellspacing="<?php echo $dcsv['cellspacing']; ?>" cellpadding="<?php echo $dcsv['cellpadding']; ?>" bgcolor="<?php echo $dcsv['tablebgcolor']; ?>">
<tr>	
<th class="">Staff Position</th>	
<th class="">Vorname</th>
<th class="">Nachname</th>
<th class="">In der Datenbank ?</th>
<th class="">Projektteam zugeordnet ?</th>
<th class="">Projektposition</th>
</tr>	
	
		<?php foreach ($this->csvstaff as $value): ?>
		<tr>
        <td><?php echo $value->position; ?></td>
        <td><?php echo $value->firstname; ?></td>
        <td><?php echo $value->lastname; ?></td>
        <?PHP
        if ( $value->person_id )
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/ok.png',
														'','title= "'.''.'"').'</td>';
        }
        else
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/error.png',
														'','title= "'.''.'"').'</td>';
        }
        
        if ( $value->project_person_id )
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/ok.png',
														'','title= "'.''.'"').'</td>';
        }
        else
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/error.png',
														'','title= "'.''.'"').'</td>';
        }
        
        ?>
        <td>
        <?php
        //$inputappend = ' disabled="disabled"'; 
        $inputappend = '';
        if ( $value->project_position_id != 0 )
								{
									$selectedvalue = $value->project_position_id;
									$append = '';
								}
								else
								{
									$selectedvalue = 0;
									$append = ' style="background-color:#FFCCCC"';
								}
        if ( $value->project_position_id == 0 )
								{
									$append=' style="background-color:#FFCCCC"';
								}
								echo JHTML::_( 'select.genericlist', $this->lists['project_staff_position_id'], 'project_staff_position_id[' . $value->nummer.']', $inputappend . 'class="inputbox" size="1" onchange="document.getElementById(\'cb' . $i . '\').checked=true"' . $append, 'value', 'text', $selectedvalue );
        ?>
        </td>
        </tr>
		<?php endforeach; ?>
	
</table>





<table id="<?php echo $dcsv['tableid']; ?>" class="table_from_csv_sortable<? if ($dcsv['sortable'] == false){ echo '_not';} ?>" width="<?php echo $dcsv['tablewidth']; ?>" border="<?php echo $dcsv['border']; ?>" cellspacing="<?php echo $dcsv['cellspacing']; ?>" cellpadding="<?php echo $dcsv['cellpadding']; ?>" bgcolor="<?php echo $dcsv['tablebgcolor']; ?>">
<tr>	
<th class="">Spieler</th>	
<th class="">Minute</th>
<th class="">R�ckennummer</th>
<th class="">f�r Nummer</th>
<th class="">f�r Spieler</th>
<th class="">Projektposition</th>
</tr>	
	
	
		<?php foreach ($this->csvinout as $value): ?>
		<tr>
        <td><?php echo $value->spieler; ?></td>
        <td><?php echo $value->in_out_time; ?></td>
        <td><?php echo $value->in; ?></td>
        <td><?php echo $value->out; ?></td>
        <td><?php echo $value->spielerout; ?></td>
        <td>
        <?php 
         
        $inputappend = '';
		$selectedvalue = 0;
		$append = ' style="background-color:#FFCCCC"';
		echo JHTML::_( 'select.genericlist', $this->lists['inout_position_id'], 'inout_position_id[' . $value->in.']', $inputappend . 'class="inputbox" size="1" onchange="document.getElementById(\'cb' . $i . '\').checked=true"' . $append, 'value', 'text', $selectedvalue );
        ?>
        </td>
        </tr>
        
        
		<?php endforeach; ?>
	
	
</table>

<table id="<?php echo $dcsv['tableid']; ?>" class="table_from_csv_sortable<? if ($dcsv['sortable'] == false){ echo '_not';} ?>" width="<?php echo $dcsv['tablewidth']; ?>" border="<?php echo $dcsv['border']; ?>" cellspacing="<?php echo $dcsv['cellspacing']; ?>" cellpadding="<?php echo $dcsv['cellpadding']; ?>" bgcolor="<?php echo $dcsv['tablebgcolor']; ?>">
<tr>	
<th class="">Spieler</th>	
<th class="">Minute</th>
<th class="">Karte</th>
<th class="">R�ckennummer</th>
<th class="">Grund</th>
<th class="">In der Datenbank ?</th>
<th class="">Event</th>
</tr>	
	
	
		<?php foreach ($this->csvcards as $value): ?>
		<tr>
        <td><?php echo $value->spieler; ?></td>
        <td><?php echo $value->event_time; ?></td>
        <td><?php echo $value->event_name; ?></td>
        <td><?php echo $value->spielernummer; ?></td>
        <td><?php echo $value->notice; ?></td>
        <?PHP
        if ( $value->event_type_id )
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/ok.png',
														'','title= "'.''.'"').'</td>';
        }
        else
        {
            echo '<td>'.JHTML::_('image','administrator/components/com_joomleague/assets/images/error.png',
														'','title= "'.''.'"').'</td>';
        }
        ?>
                
        <td>
        <?php
        $inputappend = '';
        if ( $value->event_type_id != 0 )
								{
									$selectedvalue = $value->event_type_id;
									$append = '';
								}
								else
								{
									$selectedvalue = 0;
									$append = ' style="background-color:#FFCCCC"';
								}
        if ( $value->event_type_id == 0 )
								{
									$append=' style="background-color:#FFCCCC"';
								}
        //$selectedvalue = $value->event_type_id;;
        //$append = ' style="background-color:#FFCCCC"';
        echo JHTML::_( 'select.genericlist', $this->lists['events'], 'project_events_id[' . $value->spielernummer.']', $inputappend . 'class="inputbox" size="1" onchange="document.getElementById(\'cb' . $i . '\').checked=true"' . $append, 'value', 'text', $selectedvalue );
        //echo $this->lists['events']; 
        ?>
        </td>
		<?php endforeach; ?>
	
	
</table>



<?PHP
}

?>
<input type='submit' value='<?php echo JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_SAVE_PRESSEBERICHT'); ?>' onclick='' />
<input type="hidden" name="task"				value="match.savecsvpressebericht" />
</form>