<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;

$associations += ['BelongsTo' => [], 'HasOne' => [], 'HasMany' => [], 'BelongsToMany' => []];
$immediateAssociations = $associations['BelongsTo'] + $associations['HasOne'];
$associationFields = collection($fields)
    ->map(function($field) use ($immediateAssociations) {
        foreach ($immediateAssociations as $alias => $details) {
            if ($field === $details['foreignKey']) {
                return [$field => $details];
            }
        }
    })
    ->filter()
    ->reduce(function($fields, $value) {
        return $fields + $value;
    }, []);

$pk = "\$$singularVar->{$primaryKey[0]}";

$relations = $associations['HasMany'] + $associations['BelongsToMany'];
%>

<div class="<%= $pluralVar %> view">
	<h2><?php echo ___('<%= strtolower($singularHumanName) %>'); ?></h2>
	
	<div class="panel panel-default">
		<div class="panel-heading">
		<?php
		echo $this->Navbars->actionButtons(['buttons_group' => 'view', 'model_id' => $<%= $singularVar %>->id]);
		?>
		</div>
		<div class="panel-body">
			<dl class="dl-horizontal">
			
<%
			foreach ($fields as $field) 
			{
			    if(isset($associationFields[$field]))
				{
					$isKey = false;
					if (!empty($associations['BelongsTo'])) {
						foreach ($associations['BelongsTo'] as $alias => $details) {
						
					        if(!in_array($details['alias'], ['Creator', 'Editor']))
					        {
							    if ($field === $details['foreignKey']) {
								    $isKey = true;
%>
				<dt><?php echo __('<%= Inflector::humanize(Inflector::underscore($details['property'])) %>'); ?></dt>
				<dd>
					<?php echo $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?>
				</dd>
					
<%
							        break;
							    }
							}
						}
					}
				}
				elseif(!in_array($field, $primaryKey) && !in_array($field, ['created', 'created_by', 'modified', 'modified_by']))
				{
%>
				<dt><?= ___('<%= $field %>'); ?></dt>
				<dd>
					<?php 
<%
					$fieldData = $schema->column($field);
					
					if(in_array($fieldData['type'] , ['date', 'datetime']))
					{
%>
					echo h($<%= $singularVar %>->to_display_timezone('<%= $field %>'));
<%
					}
					elseif(in_array($fieldData['type'] , ['boolean']))
					{
%>
					echo $this->AlaxosHtml->yesNo($<%= $singularVar %>-><%= $field %>);
<%
					}
					else
					{
%>
					echo h($<%= $singularVar %>-><%= $field %>);
<%
					}
%>
					?>
				</dd>
				
<%
				}
			}
%>
			</dl>
			<?php 
			echo $this->element('Alaxos.create_update_infos', ['entity' => $<%= $singularVar %>], ['plugin' => 'Alaxos']);
			?>
			<div>
			</div>
		</div>
	</div>
</div>
	
