<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class category_model extends CI_Model
{
public function create($name,$image,$insideimage,$order)
{
$data=array("name" => $name,"image" => $image,"insideimage" => $insideimage,"order" => $order);
$query=$this->db->insert( "euro_category", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("euro_category")->row();
return $query;
}
function getsinglecategory($id){
$this->db->where("id",$id);
$query=$this->db->get("euro_category")->row();
return $query;
}
public function edit($id,$name,$image,$insideimage,$order)
{
$data=array("name" => $name,"image" => $image,"insideimage" => $insideimage,"order" => $order);
$this->db->where( "id", $id );
$query=$this->db->update( "euro_category", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `euro_category` WHERE `id`='$id'");
return $query;
}
}
?>
