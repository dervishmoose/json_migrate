<?php

class JSONMigration extends Migration {
  /**
   * A constructor
   */

  public function __construct($arguments) {


    parent::__construct($arguments);


    //map for the migration
    $this->map = new MigrateSQLMap($this->machineName,
        array(
          'muid' => array(
            'type' => 'int',
            'not null' => true,
          ),
        ),
        MigrateDestinationNode::getKeySchema()
    );


    //Define JSON fields
    $fields = array(
     'title' => 'Page title',
     'description' => 'Page body',
     'createdDate' => 'Page creation date',
   );

   // Update this to point to JSON file.
   $json_file = 'https://librivox.org/api/feed/audiobooks/?authors=Dumas&format=json&limit=2&offset=6';
   $this->source = new MigrateSourceList(new NestedListJSON($json_file),new GetItemJSON($json_file, array()), $fields);


    $node_options = MigrateDestinationNode::options('und', 'full_html');
    $this->destination = new MigrateDestinationNode('page', $node_options);
    //map node's title field to the title in the json content
    $this->addFieldMapping('title', 'title');
    //map node's body field to the content in the json content
    $this->addFieldMapping('body', 'content');
    //map node's field_id field to the id in the json content
//    $this->addFieldMapping('field_id', 'id');
    //map node's field_name field to the title in the json content
    $this->addFieldMapping('field_name', 'title');
    //map node's created field to the date in the json content
    $this->addFieldMapping('created', 'date');
    //apparently you can do stuff like this:
    $this->addFieldMapping('comment', null)->defaultValue(COMMENT_NODE_CLOSED);
  }

  /**
   * Return the fields (this is cleaner than passing in the array in the MigrateSourceList class above)
   * @return array
   */
  function fields() {
    return array(
      'title' => 'The title of the content',
      'content' => 'The body of the content',
      'date' => 'Date associated with the content',
      'url' => 'Source url associated with the content',
      'image' => 'Image Source url associated with the content',
    //  'id' => 'Source ID associated with the content',
    );
  }

  /**
   * Remap fields as needed
   * @param type $row
   */
  function prepareRow($row) {
   dsm($row);
    return true;
  }

}
