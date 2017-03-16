    
    /**
     * Delete all method
     */
    public function delete_all() {
        
        $this->request->allowMethod('post', 'delete');
        
        if(isset($this->request->data['checked_ids']) && !empty($this->request->data['checked_ids'])){
            
            $<%= $pluralName %> = $this-><%= $currentModelName %>->find()->where(['id IN' => $this->request->data['checked_ids']]);
            
            $total         = $<%= $pluralName %>->count();
            $total_deleted = 0;
            
            foreach($<%= $pluralName %> as $<%= $singularName %>) {
                
                try {
                    
                    if ($this-><%= $currentModelName %>->delete($<%= $singularName %>)) {
                        $total_deleted++;
                    }
                    
                } catch(\Exception $ex) {
                    $this->log($ex);
                }
                
            }
            
            if ($total_deleted == $total) {
                
                if ($total_deleted == 1) {
                    $this->Flash->success(___('the selected <%= strtolower($singularHumanName) %> has been deleted.'), ['plugin' => 'Alaxos']);
                } elseif ($total_deleted > 1) {
                    $this->Flash->success(sprintf(__('The %s selected <%= strtolower($pluralHumanName) %> have been deleted.'), $total_deleted), ['plugin' => 'Alaxos']);
                }
                
            } else {
                
                if ($total_deleted == 0) {
                    $this->Flash->error(___('the selected <%= strtolower($pluralHumanName) %> could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
                } else {
                    $this->Flash->error(sprintf(___('only %s selected <%= strtolower($pluralHumanName) %> on %s could be deleted'), $total_deleted, $total), ['element' => 'Alaxos']);
                }
                
            }
            
        } else {
            $this->Flash->error(___('there was no <%= strtolower($singularHumanName) %> to delete'), ['plugin' => 'Alaxos']);
        }
        
        return $this->redirect(['action' => 'index']);
    }
    