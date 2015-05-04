	
	/**
	 * Delete all method
	 */
	public function delete_all() {
    	$this->request->allowMethod('post', 'delete');
    
    	if(isset($this->request->data['checked_ids']) && !empty($this->request->data['checked_ids'])){
    
    		$query = $this-><%= $currentModelName %>->query();
    		$query->delete()->where(['id IN' => $this->request->data['checked_ids']]);
    
    		try{
    			if ($statement = $query->execute()) {
    				$deleted_total = $statement->rowCount();
    				if($deleted_total == 1){
    					$this->Flash->set(___('the selected <%= strtolower($singularHumanName) %> has been deleted.'), ['element' => 'Alaxos.success']);
    				}
    				elseif($deleted_total > 1){
    					$this->Flash->set(sprintf(__('The %s selected <%= strtolower($pluralHumanName) %> have been deleted.'), $deleted_total), ['element' => 'Alaxos.success']);
    				}
    			} else {
    				$this->Flash->set(___('the selected <%= strtolower($pluralHumanName) %> could not be deleted. Please, try again.'), ['element' => 'Alaxos.error']);
    			}
    		}
    		catch(\Exception $ex){
    			$this->Flash->set(___('the selected <%= strtolower($pluralHumanName) %> could not be deleted. Please, try again.'), ['element' => 'Alaxos.error', 'params' => ['exception_message' => $ex->getMessage()]]);
    		}
    	} else {
    		$this->Flash->set(___('there was no <%= strtolower($singularHumanName) %> to delete'), ['element' => 'Alaxos.error']);
    	}
    
    	return $this->redirect(['action' => 'index']);
    }