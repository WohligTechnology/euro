<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class gallerycategory_model extends CI_Model
{
public function create($name,$image,$order)
{
$data=array("name" => $name,"image" => $image,"order" => $order);
$query=$this->db->insert( "euro_gallerycategory", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("euro_gallerycategory")->row();
return $query;
}
function getsinglegallerycategory($id){
$this->db->where("id",$id);
$query=$this->db->get("euro_gallerycategory")->row();
return $query;
}
public function edit($id,$name,$image,$order)
{
$data=array("name" => $name,"image" => $image,"order" => $order);
$this->db->where( "id", $id );
$query=$this->db->update( "euro_gallerycategory", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `euro_gallerycategory` WHERE `id`='$id'");
return $query;
}


}
?>
