
<?php
//create list table to show ananas preference message in backoffice
if(is_admin())
{
    new DLHL_Wp_List_Table();
}

class DLHL_Wp_List_Table
{
    /**
     * Constructor will create the menu item
     */
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'add_menu_example_list_table_page' ));
    }
    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_menu_example_list_table_page()
    {
        add_menu_page( 'Préférences des utilisateurs', 'Préférences des utilisateurs', 'manage_options', 'example-list-table.php', array($this, 'list_table_page') );

        /* add_menu_page( 'Inscritions ', 'Inscritions ', 'manage_options', 'example-list-table.php', array($this, 'list_table_page') ); */
    }
    /**
     * Display the list table page
     *
     * @return Void
     */
    public function list_table_page()
    {
        $exampleListTable = new Example_List_Table();
        $exampleListTable->prepare_items();
        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>
                <h2>Préférences des utilisateurs</h2>
                <?php $exampleListTable->display(); ?>
            </div>
        <?php
    }
}
// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
/**
 * Create a new table class that will extend the WP_List_Table
 */
class Example_List_Table extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );
        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }
    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'user name'       =>'User name',
            'preference'      => 'aime tu les ananas?',
            
        );
        return $columns;
    }
    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }
    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array('title' => array('title', false));
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'users';
        
        $results = $GLOBALS['wpdb']->get_results("SELECT * FROM  {$table_name}  ",  OBJECT) ;
         $data = array();
         foreach ($results as $results) {
            //var_dump($results) ;
            $text=$results->preferences_utilisateur;        
            $firstname=$results->user_nicename;
            
            $data[] = array(
                         'user name'      =>$firstname,
                         'preference'      =>$text
                         
                         );
                        }
                       
                        return $data;
                       
    }
   
    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            
            case 'user name':
            case 'preference':
            
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }
   
    
}
?>