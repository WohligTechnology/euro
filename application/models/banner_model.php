<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class banner_model extends CI_Model
{
public function create($order,$image,$title)
{
$data=array("order" => $order,"image" => $image,"title" => $title);
$query=$this->db->insert( "euro_banner", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("euro_banner")->row();
return $query;
}
function getsinglebanner($id){
$this->db->where("id",$id);
$query=$this->db->get("euro_banner")->row();
return $query;
}
public function edit($id,$order,$image,$title)
{
$data=array("order" => $order,"image" => $image,"title" => $title);
$this->db->where( "id", $id );
$query=$this->db->update( "euro_banner", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `euro_banner` WHERE `id`='$id'");
return $query;
}
}
?>
