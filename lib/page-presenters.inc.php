<?php


require_once('lib/db.inc.php');
require_once('lib/search.inc.php');
require_once('lib/people.inc.php');
require_once('lib/comments.inc.php');
require_once('lib/tags.inc.php');
require_once('lib/messages.inc.php');

class page_presenters{

    /**
     * Add page_presenter
     *
     * @param  $data  [array]  Assoc array of data, keys should match db columns
     * @return [int]  Positive int if successful, negative error otherwise
     */
    function add($data){
        //sanitize input and form query
        $data = db_sanitize($data);
        $parts = db_array2insert($data);
        $query = 'insert into page_captains ('.$parts['columns'].') values ('.$parts['values'].')';

        //run query
        db_query($query);
        
        //update query
        search::index('page_captains', $data['page'], $data['person_id']);

        return $data['page'];
    }


     /**
      * Update page_presenter (for updating status, use update_status())
      * 
      * @param $id    [int]  Page number
      * @param $data  [array]  Assoc array of updated data, keys should match db columns
      * @param $sig   [string]  Sig of user performing this action
      * @return [int] 0 on success, negative error code otherwise
      */
     function update($id, $data, $sig){


         //sanitize input and form query
         $id = db_sanitize($id);
         $data = db_sanitize($data);
         $set= db_array2update($data);
         $query = 'UPDATE page_captains SET '.$set.' WHERE page='.$id;
         
         db_query($query);

         return 0;
     } 


     /**
      * Get page_presenter info
      *
      * @param $id  [int]  Page_Presenter ID
      * @param $basic  [bool]  Set to true to return just basic info 
      * @return [array]  Assoc array containing page_presenter info
      */
     function get_info($id,$basic=false){
         $id = db_sanitize($id);

         $query = "SELECT * FROM page_captains WHERE page='$id'";
         $r = db_query($query);

         $a = db_fetch($r);
          return $a;
     }

     function get_all() {
     $query = "SELECT * FROM page_captains";
     $r = db_query($query);
     }

      /**
      * Get nickname, ids, roles of presenters
      *
      * @param  $id [int]  Page_Presenter ID
      * @return [array]
      */
     function get_page_presenter_participants($id){
         $id = db_sanitize($id,true);
         $query = 'select pc.person_id,pc.page,p.nickname from page_captains pc, people p ';
         $query.= "where pc.page='$id' and pc.person_id=p.person_id";
         $r = db_query($query);
         return db_fetch_all($r);
     }



}
?>
