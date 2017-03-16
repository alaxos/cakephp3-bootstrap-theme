
    /**
     * Delete all method
     */
    public function deleteAll() {

        $this->request->allowMethod('post', 'delete');

        if($this->request->getData('checked_ids') !== null && !empty($this->request->getData('checked_ids'))){

            $<%= $pluralName %> = $this-><%= $currentModelName %>->find()->where(['id IN' => $this->request->getData('checked_ids')]);

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
                    $this->Flash->success(__('The selected <%= strtolower($singularHumanName) %> has been deleted.'), ['plugin' => 'Alaxos']);
                } elseif ($total_deleted > 1) {
                    $this->Flash->success(sprintf(__('The %s selected <%= strtolower($pluralHumanName) %> have been deleted.'), $total_deleted), ['plugin' => 'Alaxos']);
                }

            } else {

                if ($total_deleted == 0) {
                    $this->Flash->error(__('The selected <%= strtolower($pluralHumanName) %> could not be deleted. Please, try again.'), ['plugin' => 'Alaxos']);
                } else {
                    $this->Flash->error(sprintf(__('Only %s selected <%= strtolower($pluralHumanName) %> on %s could be deleted'), $total_deleted, $total), ['plugin' => 'Alaxos']);
                }

            }

        } else {
            $this->Flash->error(__('There was no <%= strtolower($singularHumanName) %> to delete'), ['plugin' => 'Alaxos']);
        }

        return $this->redirect(['action' => 'index']);
    }
