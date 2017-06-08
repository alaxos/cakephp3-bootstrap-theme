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

//$fields = collection($fields)
//    ->filter(function($field) use ($schema) {
//        return !in_array($schema->columnType($field), ['binary', 'text']);
//    })
//    ->take(7);

$has_text_field = false;
foreach ($fields as $field) {
    if($schema->columnType($field) == 'text'){
        $has_text_field = true;
        break;
    }
}

$hidden_fields = ['password', 'created_by', 'modified_by'];
%>
<%
if($has_text_field){
%>
<?php 
use Alaxos\Lib\StringTool;
?>

<%
}
%>
<div class="<%= $pluralVar %> index">
	
	<h2><?= __('<%= strtolower($pluralHumanName) %>'); ?></h2>
	
	<div class="panel panel-default">
		<div class="panel-heading">
		<?php
		echo $this->Navbars->actionButtons(['paginate_infos' => true, 'select_pagination_limit' => true]);
		?>
		</div>
		<div class="panel-body">
			
			<div class="table-responsive">
			
			<table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
			<thead>
			<tr class="sortHeader">
				<th></th>
<%
foreach ($fields as $field) {
	if(!in_array($field, $primaryKey))
	{
        if(!in_array($field, $hidden_fields))
        {
            if(in_array($schema->columnType($field), ['date', 'datetime']))
            {
%>
				<th style="width:160px;"><?php echo $this->Paginator->sort('<%= $field %>', ___('<%= $field %>')); ?></th>
<%
            }
            else
            {
%>
				<th><?php echo $this->Paginator->sort('<%= $field %>', ___('<%= $field %>')); ?></th>
<%
            }
        }
	}
}
%>
				<th class="actions"></th>
			</tr>
			<tr class="filterHeader">
				<td>
				<?php
				echo $this->AlaxosForm->checkbox('_Tech.selectAll', ['id' => 'TechSelectAll']);
				
				echo $this->AlaxosForm->create($search_entity, array('url' => [], 'class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate'));
				?>
				</td>
<%
foreach ($fields as $field) {
	if(!in_array($field, $primaryKey))
	{
        if(!in_array($field, $hidden_fields))
        {
%>
				<td>
					<?php
<%
				if(in_array($schema->columnType($field), ['datetime']))
				{
%>
					echo $this->AlaxosForm->filterDate('<%= $field %>');
<%
				}
				else
				{
%>
					echo $this->AlaxosForm->filterField('<%= $field %>');
<%
				}
%>
					?>
				</td>
<%
        }
	}
}
%>
				<td>
					<?php
					echo $this->AlaxosForm->button(___('filter'), ['class' => 'btn btn-default']);
					echo $this->AlaxosForm->end();
					?>
				</td>
			</tr>
			</thead>
			
			<tbody>
			<?php foreach ($<%= $pluralVar %> as $i => $<%= $singularVar %>): ?>
				<tr>
					<td>
						<?php
						echo $this->AlaxosForm->checkBox('<%= $singularHumanName %>.' . $i . '.id', array('value' => $<%= $singularVar %>->id, 'class' => 'model_id'));
						?>
					</td>
<%				foreach ($fields as $field) { 
						
						$isKey = false;
						if (!empty($associations['BelongsTo'])) {
							foreach ($associations['BelongsTo'] as $alias => $details) {
								if ($field === $details['foreignKey']) {
									$isKey = true;
									
                                    if(!in_array($field, $hidden_fields))
                                    {
%>
					<td>
						<?php echo $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : ''; ?>
					</td>
<%
                                    }
								}
							}
						}
					
					if(!$isKey && !in_array($field, $primaryKey))
					{
                        if(!in_array($field, $hidden_fields))
                        {
%>
					<td>
<%
						if(in_array($schema->columnType($field), ['date', 'datetime']))
						{
%>
						<?php echo h($<%= $singularVar %>->to_display_timezone('<%= $field %>')); ?>
<%
						}
						elseif(in_array($schema->columnType($field), ['boolean']))
						{
%>
						<?php echo $this->AlaxosHtml->yesNo($<%= $singularVar %>-><%= $field %>); ?>
<%
						}
						elseif(in_array($schema->columnType($field), ['text']))
						{
%>
						<?php echo h(StringTool::shorten($<%= $singularVar %>-><%= $field %>)); ?>
<%
						}
						else
						{
%>
						<?php echo h($<%= $singularVar %>-><%= $field %>) ?>
<%
						}
%>
					</td>
<%
                        }
					}
				}
				
					$pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
					<td class="actions">
						<?php 
// 						echo $this->Navbars->actionButtons(['buttons_group' => 'list_item', 'buttons_list_item' => [['view', 'edit', 'delete']], 'model_id' => <%= $pk %>]);
						?>
						
						<?php 
// 						echo $this->Html->link('<span class="glyphicon glyphicon-search"></span> ' . __d('alaxos', 'view'), ['action' => 'view', <%= $pk %>], ['class' => 'to_view', 'escape' => false]);
// 						echo ' ';
// 						echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span> ' . __d('alaxos', 'edit'), ['action' => 'edit', <%= $pk %>], ['escape' => false]);
// 						echo ' ';
// 						echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span> ' . __d('alaxos', 'delete'), ['action' => 'delete', <%= $pk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>), 'escape' => false]);
						?>
						
						<?php 
						echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', ['action' => 'view', <%= $pk %>], ['class' => 'to_view', 'escape' => false]);
						echo '&nbsp;&nbsp;';
						echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', <%= $pk %>], ['escape' => false]);
						echo '&nbsp;&nbsp;';
						echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>', ['action' => 'delete', <%= $pk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>), 'escape' => false]);
						?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			
			</table>
			
			</div>
			
			<?php
			if(isset($<%= $pluralVar %>) && $<%= $pluralVar %>->count() > 0)
			{
				echo '<div class="row">';
				echo '<div class="col-md-1">';
				echo $this->AlaxosForm->postActionAllButton(__d('alaxos', 'delete all'), ['action' => 'delete_all'], ['confirm' => __d('alaxos', 'do you really want to delete the selected items ?')]);
				echo '</div>';
				echo '</div>';
			}
			?>
			
			<div class="paging text-center">
				<ul class="pagination pagination-sm">
				<?php
				$this->Paginator->templates(['ellipsis' => '<li class="ellipsis"><span>...</span></li>']);
				echo $this->Paginator->prev('< ' . __('previous'));
				echo $this->Paginator->numbers(['first' => 2, 'last' => 2]);
				echo $this->Paginator->next(__('next') . ' >');
				?>
				</ul>
			</div>
			
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	Alaxos.start();
});
</script>
