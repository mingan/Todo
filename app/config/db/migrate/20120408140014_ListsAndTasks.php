<?php

class ListsAndTasks extends Ruckusing_BaseMigration {

  public function up() {
      $t = $this->create_table("lists", array("id" => true));
      $t->column("name", "string", array('null' => false));
      $t->column("created", "datetime", array('null' => false));
      $t->column("modified", "datetime", array('null' => false));
      $t->finish();

      $t = $this->create_table("tasks", array("id" => true));
      $t->column("list_id", "integer", array('null' => false));
      $t->column("name", "string", array('null' => false));
      $t->column("desc", "text");
      $t->column("completed", "boolean", array('null' => false));
      $t->column("completed_at", "datetime");
      $t->column("created", "datetime", array('null' => false));
      $t->column("modified", "datetime", array('null' => false));
	  $t->finish();

	  $this->add_index('tasks', 'list_id');
	  $this->add_index('tasks', array('completed', 'completed_at'));
  }//up()

  public function down() {
	  $this->remove_index('tasks', 'list_id');
	  $this->remove_index('tasks', array('completed', 'completed_at'));
	  $this->drop_table('tasks');
	  $this->drop_table('lists');
  }//down()
}
?>