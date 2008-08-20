<?php
/*
 * potd.php
 *
 * pic and show one picture per day per model
 *
 * GET params:
 *  - affid (aid)
 *  - siteid (sid)
 *  - program id (program_id)
 *  - model id (model)
 */

       require_once	'phpinclude/classAffiliateProgramDB.inc.php';
       require_once	'phpinclude/classSmartyEC.inc.php';
       require_once	'HTML/Table.php';
       require_once	'HTML/QuickForm.php';

       define( 'PICS_DIR', 'admin/potd_admin/pics' );
       define( 'TRACK_URL', '/track/track.php' );
       define( 'DEFAULT_TEMPLATE', 'potd.html' );

       $db = new AffiliateProgramDB;
       $db->connect_to_db();
       
       if( isset( $_REQUEST['tpl'] ))
       {
		$template = basename( $_REQUEST['tpl'] ).'.html';
       } else {
		$template = DEFAULT_TEMPLATE;
       }

       $action = $_REQUEST['action'];
       if( $action == 'image' ) {       
           $model = $_REQUEST['model'];
           if( $model == '' )
                 $model = 1;

           $today = mktime(0,0,0,date('m'),date('d'),date('Y'));

           if( $_REQUEST['preview'] ) {
                 // show first pic for this model
                 $query = "SELECT id,filename FROM potd_model_pic WHERE model_id=$model ORDER BY id";
           } else {       
                 // find today's pic for this model
                 $query = "SELECT id,filename FROM potd_model_pic WHERE model_id=$model AND date_shown=$today";
           }
           $res = $db->query( $query );
           $rows = $res->numRows();
           if( !$rows ) {
                 // if no pic for today, pick one and show it
                 $query = "SELECT min(id) AS id FROM potd_model_pic WHERE model_id=$model AND date_shown=0";
                 $res = $db->query( $query );
                 $ar = $res->fetchRow( DB_FETCHMODE_ASSOC );
                 // 20070130 - if we went through all of them, recycle
                 if( $ar['id'] == '' )
                 {
			$query = "UPDATE potd_model_pic SET date_shown=0 WHERE model_id=$model";
			$res = $db->query( $query );
			$query = "SELECT min(id) AS id FROM potd_model_pic WHERE model_id=$model AND date_shown=0";
			$res = $db->query( $query );
			$ar = $res->fetchRow( DB_FETCHMODE_ASSOC );
                 }
                 $id = $ar['id'];
                 $query = "UPDATE potd_model_pic SET date_shown=$today WHERE id=$id";
                 $res = $db->query( $query );
                 $query = "SELECT id,filename FROM potd_model_pic WHERE model_id=$model AND date_shown=$today";
                 $res = $db->query( $query );
           }

           // show today's pic
           $ar = $res->fetchRow( DB_FETCHMODE_ASSOC );
           $filename = $ar['filename'];
           $file = PICS_DIR.'/'.$model.'_'.$filename;
           
          $type = strtolower(substr( $file, -3, 3 ));
          if( $type == 'jpg' ) {
              $mimetype = 'image/jpeg';
          }
          if( $type == 'gif' ) {
              $mimetype = 'image/gif';
          }
          if( $type == 'peg' ) {
              $mimetype = 'image/jpeg';
          }
          $data = file_get_contents( $file );
          header('Content-type: '.$mimetype );
          echo $data;
	  exit;
       }

       $query = "SELECT name FROM potd_model WHERE id=".$_REQUEST['model'];
       $res = $db->query( $query );
       if( PEAR::isError( $res )) {
           exit;
       }
       $ar = $res->fetchRow( DB_FETCHMODE_ASSOC );
       $name = $ar['name'];
       
       $clickthru = TRACK_URL."?aid=".$_REQUEST['aid']."&sid=".$_REQUEST['sid']."&program_id=".$_REQUEST['program_id'];
       $imgurl = "potd.php?action=image&model=".$_REQUEST['model'];
       
       $smarty = new SmartyEC( 'templates/' );
       $smarty->assign( 'clickthru', $clickthru );
       $smarty->assign( 'imgurl', $imgurl );
       $smarty->assign( 'name', $name );

       $smarty->display( $template );      
