<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{function getallnewsletter()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_newsletter`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`euro_newsletter`.`email`";
$elements[1]->sort="1";
$elements[1]->header="Email Id";
$elements[1]->alias="email";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`euro_newsletter`.`timestamp`";
$elements[2]->sort="1";
$elements[2]->header="Timestamp";
$elements[2]->alias="timestamp";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_newsletter`");
$this->load->view("json",$data);
}
public function getsinglenewsletter()
{
$id=$this->input->get_post("id");
$data["message"]=$this->newsletter_model->getsinglenewsletter($id);
$this->load->view("json",$data);
}
function getallbanner()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_banner`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`euro_banner`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`euro_banner`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`euro_banner`.`title`";
$elements[3]->sort="1";
$elements[3]->header="Title";
$elements[3]->alias="title";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_banner`");
$this->load->view("json",$data);
}
public function getsinglebanner()
{
$id=$this->input->get_post("id");
$data["message"]=$this->banner_model->getsinglebanner($id);
$this->load->view("json",$data);
}
function getallconfig()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_config`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`euro_config`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_config`");
$this->load->view("json",$data);
}
public function getsingleconfig()
{
$id=$this->input->get_post("id");
$data["message"]=$this->config_model->getsingleconfig($id);
$this->load->view("json",$data);
}
function getallcategory()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_category`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`euro_category`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`euro_category`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`euro_category`.`insideimage`";
$elements[3]->sort="1";
$elements[3]->header="Inside Image";
$elements[3]->alias="insideimage";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`euro_category`.`order`";
$elements[4]->sort="1";
$elements[4]->header="Order";
$elements[4]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_category`");
$this->load->view("json",$data);
}
public function getsinglecategory()
{
$id=$this->input->get_post("id");
$data["message"]=$this->category_model->getsinglecategory($id);
$this->load->view("json",$data);
}
function getallproduct()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_product`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`euro_product`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`euro_product`.`category`";
$elements[2]->sort="1";
$elements[2]->header="Category";
$elements[2]->alias="category";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`euro_product`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`euro_product`.`image`";
$elements[4]->sort="1";
$elements[4]->header="Image";
$elements[4]->alias="image";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`euro_product`.`name`";
$elements[5]->sort="1";
$elements[5]->header="Name";
$elements[5]->alias="name";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`euro_product`.`desc`";
$elements[6]->sort="1";
$elements[6]->header="Description";
$elements[6]->alias="desc";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_product`");
$this->load->view("json",$data);
}
public function getsingleproduct()
{
$id=$this->input->get_post("id");
$data["message"]=$this->product_model->getsingleproduct($id);
$this->load->view("json",$data);
}
function getallgallerycategory()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_gallerycategory`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`euro_gallerycategory`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`euro_gallerycategory`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`euro_gallerycategory`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_gallerycategory`");
$this->load->view("json",$data);
}
public function getsinglegallerycategory()
{
$id=$this->input->get_post("id");
$data["message"]=$this->gallerycategory_model->getsinglegallerycategory($id);
$this->load->view("json",$data);
}
function getallgalleryimage()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_galleryimage`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`euro_galleryimage`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`euro_galleryimage`.`gallerycategory`";
$elements[2]->sort="1";
$elements[2]->header="Gallery Category";
$elements[2]->alias="gallerycategory";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`euro_galleryimage`.`name`";
$elements[3]->sort="1";
$elements[3]->header="Name";
$elements[3]->alias="name";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_galleryimage`");
$this->load->view("json",$data);
}
public function getsinglegalleryimage()
{
$id=$this->input->get_post("id");
$data["message"]=$this->galleryimage_model->getsinglegalleryimage($id);
$this->load->view("json",$data);
}
function getallenquiry()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_enquiry`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`euro_enquiry`.`status`";
$elements[1]->sort="1";
$elements[1]->header="Status";
$elements[1]->alias="status";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`euro_enquiry`.`name`";
$elements[2]->sort="1";
$elements[2]->header="Name";
$elements[2]->alias="name";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`euro_enquiry`.`email`";
$elements[3]->sort="1";
$elements[3]->header="Email Id";
$elements[3]->alias="email";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`euro_enquiry`.`telephone`";
$elements[4]->sort="1";
$elements[4]->header="Telephone";
$elements[4]->alias="telephone";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`euro_enquiry`.`timestamp`";
$elements[5]->sort="1";
$elements[5]->header="Timestamp";
$elements[5]->alias="timestamp";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`euro_enquiry`.`query`";
$elements[6]->sort="1";
$elements[6]->header="Query";
$elements[6]->alias="query";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_enquiry`");
$this->load->view("json",$data);
}
public function getsingleenquiry()
{
$id=$this->input->get_post("id");
$data["message"]=$this->enquiry_model->getsingleenquiry($id);
$this->load->view("json",$data);
}
function getallhomecategory()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_homecategory`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`euro_homecategory`.`product1`";
$elements[1]->sort="1";
$elements[1]->header="Product1";
$elements[1]->alias="product1";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`euro_homecategory`.`product2`";
$elements[2]->sort="1";
$elements[2]->header="Product2";
$elements[2]->alias="product2";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`euro_homecategory`.`product3`";
$elements[3]->sort="1";
$elements[3]->header="Product3";
$elements[3]->alias="product3";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`euro_homecategory`.`product4`";
$elements[4]->sort="1";
$elements[4]->header="Product4";
$elements[4]->alias="product4";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`euro_homecategory`.`name`";
$elements[5]->sort="1";
$elements[5]->header="Name";
$elements[5]->alias="name";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`euro_homecategory`.`image1`";
$elements[6]->sort="1";
$elements[6]->header="Image1";
$elements[6]->alias="image1";

$elements=array();
$elements[7]=new stdClass();
$elements[7]->field="`euro_homecategory`.`imagehover`";
$elements[7]->sort="1";
$elements[7]->header="Image Hover";
$elements[7]->alias="imagehover";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_homecategory`");
$this->load->view("json",$data);
}
public function getsinglehomecategory()
{
$id=$this->input->get_post("id");
$data["message"]=$this->homecategory_model->getsinglehomecategory($id);
$this->load->view("json",$data);
}
} ?>