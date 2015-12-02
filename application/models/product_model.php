<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class product_model extends CI_Model
{
public function create($name,$category,$order,$image,$name,$desc)
{
$data=array("name" => $name,"category" => $category,"order" => $order,"image" => $image,"name" => $name,"desc" => $desc);
$query=$this->db->insert( "euro_product", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("euro_product")->row();
return $query;
}
function getsingleproduct($id){
$this->db->where("id",$id);
$query=$this->db->get("euro_product")->row();
return $query;
}
public function edit($id,$name,$category,$order,$image,$name,$desc)
{
$data=array("name" => $name,"category" => $category,"order" => $order,"image" => $image,"name" => $name,"desc" => $desc);
$this->db->where( "id", $id );
$query=$this->db->update( "euro_product", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `euro_product` WHERE `id`='$id'");
return $query;
}
        public function getcategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `euro_category`  ORDER BY `id` ASC")->result();
		$return=array(
		
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
}
?>
