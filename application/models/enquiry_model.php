<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class enquiry_model extends CI_Model
{
public function create($status,$name,$email,$telephone,$timestamp,$query)
{
$data=array("status" => $status,"name" => $name,"email" => $email,"telephone" => $telephone,"timestamp" => $timestamp,"query" => $query);
$query=$this->db->insert( "euro_enquiry", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("euro_enquiry")->row();
return $query;
}
function getsingleenquiry($id){
$this->db->where("id",$id);
$query=$this->db->get("euro_enquiry")->row();
return $query;
}
public function edit($id,$status,$name,$email,$telephone,$timestamp,$query)
{
$data=array("status" => $status,"name" => $name,"email" => $email,"telephone" => $telephone,"timestamp" => $timestamp,"query" => $query);
$this->db->where( "id", $id );
$query=$this->db->update( "euro_enquiry", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `euro_enquiry` WHERE `id`='$id'");
return $query;
}
}
?>
