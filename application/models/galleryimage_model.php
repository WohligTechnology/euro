<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class galleryimage_model extends CI_Model
{
public function create($order,$gallerycategory,$name)
{
$data=array("order" => $order,"gallerycategory" => $gallerycategory,"name" => $name);
$query=$this->db->insert( "euro_galleryimage", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("euro_galleryimage")->row();
return $query;
}
function getsinglegalleryimage($id){
$this->db->where("id",$id);
$query=$this->db->get("euro_galleryimage")->row();
return $query;
}
public function edit($id,$order,$gallerycategory,$name)
{
$data=array("order" => $order,"gallerycategory" => $gallerycategory,"name" => $name);
$this->db->where( "id", $id );
$query=$this->db->update( "euro_galleryimage", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `euro_galleryimage` WHERE `id`='$id'");
return $query;
}
}
?>
