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

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });
%>

<div class="<%= $pluralVar %> form">
	
	<fieldset>
		<legend><?= __('<%= strtolower(Inflector::humanize($action)) %> <%= strtolower($singularHumanName) %>') ?></legend>
		
		<div class="panel panel-default">
			<div class="panel-heading">
			<?php
<%
			if (strpos($action, 'add') === false)
        	{
        		$pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
			echo $this->Navbars->actionButtons(['buttons_group' => 'edit', 'model_id' => <%= $pk %>]);
<%
        	}
        	else
        	{
%>
			echo $this->Navbars->actionButtons(['buttons_group' => 'add']);
<%
        	}
%>
			?>
			</div>
			<div class="panel-body">
			
			<?php
			echo $this->AlaxosForm->create($<%= $singularVar %>, ['class' => 'form-horizontal', 'role' => 'form', 'novalidate' => 'novalidate']);
<%
// debug($primaryKey);
// debug($keyFields);
        foreach ($fields as $field) {
        	
        	if (!in_array($field, ['created', 'modified', 'updated', 'created_by', 'modified_by']))
        	{
	            if (in_array($field, $primaryKey)) {
	            	/*
	            	 * Case of primary key field
	            	 */
	                continue;
	            }
            
            
%>
			
			echo '<div class="form-group">';
			echo $this->AlaxosForm->label('<%= $field %>', __('<%= $field %>'), ['class' => 'col-sm-2 control-label']);
			echo '<div class="col-sm-5">';
<%
            
            
	            if (isset($keyFields[$field])) 
	            {
	            	/*
	            	 * Case of linked models
	            	 */
	                $fieldData = $schema->column($field);
	                if (!empty($fieldData['null'])) {
%>
			echo $this->AlaxosForm->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true, 'label' => false, 'class' => 'form-control']);
<%
                	} else {
%>
			echo $this->AlaxosForm->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'label' => false, 'class' => 'form-control']);
<%
	                }
	            }
	            elseif (!in_array($field, ['created', 'modified', 'updated', 'created_by', 'modified_by'])) 
	            {
	            	/*
	            	 * All other cases
	            	 */
	                $fieldData = $schema->column($field);
	                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
			echo $this->AlaxosForm->input('<%= $field %>', ['empty' => true, 'default' => '', 'label' => false, 'class' => 'form-control']);
<%
	                } 
	                else 
	                {
%>
			echo $this->AlaxosForm->input('<%= $field %>', ['label' => false, 'class' => 'form-control']);
<%
	                }
	            }
%>
			echo '</div>';
			echo '</div>';
<%
        	}
        }
%>
			
			echo '<div class="form-group">';
			echo '<div class="col-sm-offset-2 col-sm-5">';
			echo $this->AlaxosForm->button(___('submit'), ['class' => 'btn btn-default']);
			echo '</div>';
			echo '</div>';
			
			echo $this->AlaxosForm->end(); 
			?>
			</div>
		</div>
		
	</fieldset>
	
<%
        
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            echo $this->AlaxosForm->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
<%
            }
        }
%>
	
</div>
