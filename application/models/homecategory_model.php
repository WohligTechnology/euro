<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class homecategory_model extends CI_Model
{
public function create($product1,$product2,$product3,$product4,$name,$image1,$imagehover)
{
$data=array("product1" => $product1,"product2" => $product2,"product3" => $product3,"product4" => $product4,"name" => $name,"image1" => $image1,"imagehover" => $imagehover);
$query=$this->db->insert( "euro_homecategory", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("euro_homecategory")->row();
return $query;
}
function getsinglehomecategory($id){
$this->db->where("id",$id);
$query=$this->db->get("euro_homecategory")->row();
return $query;
}
public function edit($id,$product1,$product2,$product3,$product4,$name,$image1,$imagehover)
{
$data=array("product1" => $product1,"product2" => $product2,"product3" => $product3,"product4" => $product4,"name" => $name,"image1" => $image1,"imagehover" => $imagehover);
$this->db->where( "id", $id );
$query=$this->db->update( "euro_homecategory", $data );
return 1;
}
    
        public function getImageById($id)
    {
        $query = $this->db->query('SELECT `imagehover` FROM `euro_homecategory` WHERE `id`=('.$this->db->escape($id).')')->row();

        return $query;
    }
    
public function delete($id)
{
$query=$this->db->query("DELETE FROM `euro_homecategory` WHERE `id`='$id'");
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
            public function getproduct1dropdown()
	{
		$query=$this->db->query("SELECT * FROM `euro_homecategory`  ORDER BY `id` ASC")->result();
		$return=array(
		
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}         
    
    public function getproduct2dropdown()
	{
		$query=$this->db->query("SELECT * FROM `euro_homecategory`  ORDER BY `id` ASC")->result();
		$return=array(
		
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}           
    
    public function getproduct3dropdown()
	{
		$query=$this->db->query("SELECT * FROM `euro_homecategory`  ORDER BY `id` ASC")->result();
		$return=array(
		
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}            
    
    public function getproduct4dropdown()
	{
		$query=$this->db->query("SELECT * FROM `euro_homecategory`  ORDER BY `id` ASC")->result();
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
