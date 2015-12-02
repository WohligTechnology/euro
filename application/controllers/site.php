<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
    public function getOrderingDone()
    {
        $orderby=$this->input->get("orderby");
        $ids=$this->input->get("ids");
        $ids=explode(",",$ids);
        $tablename=$this->input->get("tablename");
        $where=$this->input->get("where");
        if($where == "" || $where=="undefined")
        {
            $where=1;
        }
        $access = array(
            '1',
        );
        $this->checkAccess($access);
        $i=1;
        foreach($ids as $id)
        {
            //echo "UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = `$id` AND $where";
            $this->db->query("UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = '$id' AND $where");
            $i++;
            //echo "/n";
        }
        $data["message"]=true;
        $this->load->view("json",$data);
        
    }
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
//            $category=$this->input->post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`logintype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('templatewith2',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    
    
    public function viewnewsletter()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewnewsletter";
$data["base_url"]=site_url("site/viewnewsletterjson");
$data["title"]="View newsletter";
$this->load->view("template",$data);
}
function viewnewsletterjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_newsletter`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`euro_newsletter`.`email`";
$elements[1]->sort="1";
$elements[1]->header="Email Id";
$elements[1]->alias="email";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_newsletter`");
$this->load->view("json",$data);
}

public function createnewsletter()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createnewsletter";
$data["title"]="Create newsletter";
$this->load->view("template",$data);
}
public function createnewslettersubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("email","Email Id","trim");
$this->form_validation->set_rules("timestamp","Timestamp","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createnewsletter";
$data["title"]="Create newsletter";
$this->load->view("template",$data);
}
else
{
$email=$this->input->get_post("email");
$timestamp=$this->input->get_post("timestamp");
if($this->newsletter_model->create($email,$timestamp)==0)
$data["alerterror"]="New newsletter could not be created.";
else
$data["alertsuccess"]="newsletter created Successfully.";
$data["redirect"]="site/viewnewsletter";
$this->load->view("redirect",$data);
}
}
public function editnewsletter()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editnewsletter";
$data["title"]="Edit newsletter";
$data["before"]=$this->newsletter_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editnewslettersubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("email","Email Id","trim");
$this->form_validation->set_rules("timestamp","Timestamp","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editnewsletter";
$data["title"]="Edit newsletter";
$data["before"]=$this->newsletter_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$email=$this->input->get_post("email");
$timestamp=$this->input->get_post("timestamp");
if($this->newsletter_model->edit($id,$email,$timestamp)==0)
$data["alerterror"]="New newsletter could not be Updated.";
else
$data["alertsuccess"]="newsletter Updated Successfully.";
$data["redirect"]="site/viewnewsletter";
$this->load->view("redirect",$data);
}
}
public function deletenewsletter()
{
$access=array("1");
$this->checkaccess($access);
$this->newsletter_model->delete($this->input->get("id"));
$data["redirect"]="site/viewnewsletter";
$this->load->view("redirect",$data);
}
public function viewbanner()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewbanner";
$data["base_url"]=site_url("site/viewbannerjson");
$data["title"]="View banner";
$this->load->view("template",$data);
}
function viewbannerjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_banner`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`euro_banner`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";
$elements[2]=new stdClass();
$elements[2]->field="`euro_banner`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_banner`");
$this->load->view("json",$data);
}

public function createbanner()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createbanner";
$data["title"]="Create banner";
$this->load->view("template",$data);
}
public function createbannersubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("title","Title","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createbanner";
$data["title"]="Create banner";
$this->load->view("template",$data);
}
else
{
$order=$this->input->get_post("order");
//$image=$this->input->get_post("image");
$title=$this->input->get_post("title");
     $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
if($this->banner_model->create($order,$image,$title)==0)
$data["alerterror"]="New banner could not be created.";
else
$data["alertsuccess"]="banner created Successfully.";
$data["redirect"]="site/viewbanner";
$this->load->view("redirect",$data);
}
}
public function editbanner()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editbanner";
$data["title"]="Edit banner";
$data["before"]=$this->banner_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editbannersubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("title","Title","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editbanner";
$data["title"]="Edit banner";
$data["before"]=$this->banner_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$order=$this->input->get_post("order");
$image=$this->input->get_post("image");
$title=$this->input->get_post("title");
             $config['upload_path'] = './uploads/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$this->load->library('upload', $config);
						$filename="image";
						$image="";
						if (  $this->upload->do_upload($filename))
						{
							$uploaddata = $this->upload->data();
							$image=$uploaddata['file_name'];
						}

						if($image=="")
						{
						$image=$this->homeslide_model->getimagebyid($id);
						   // print_r($image);
							$image=$image->image;
						}
if($this->banner_model->edit($id,$order,$image,$title)==0)
$data["alerterror"]="New banner could not be Updated.";
else
$data["alertsuccess"]="banner Updated Successfully.";
$data["redirect"]="site/viewbanner";
$this->load->view("redirect",$data);
}
}
public function deletebanner()
{
$access=array("1");
$this->checkaccess($access);
$this->banner_model->delete($this->input->get("id"));
$data["redirect"]="site/viewbanner";
$this->load->view("redirect",$data);
}
public function viewconfig()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewconfig";
$data["base_url"]=site_url("site/viewconfigjson");
$data["title"]="View config";
$this->load->view("template",$data);
}
function viewconfigjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_config`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_config`");
$this->load->view("json",$data);
}

public function createconfig()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createconfig";
$data["title"]="Create config";
$this->load->view("template",$data);
}
public function createconfigsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createconfig";
$data["title"]="Create config";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
if($this->config_model->create($name)==0)
$data["alerterror"]="New config could not be created.";
else
$data["alertsuccess"]="config created Successfully.";
$data["redirect"]="site/viewconfig";
$this->load->view("redirect",$data);
}
}
public function editconfig()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editconfig";
$data["title"]="Edit config";
$data["before"]=$this->config_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editconfigsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("name","Name","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editconfig";
$data["title"]="Edit config";
$data["before"]=$this->config_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
if($this->config_model->edit($id,$name)==0)
$data["alerterror"]="New config could not be Updated.";
else
$data["alertsuccess"]="config Updated Successfully.";
$data["redirect"]="site/viewconfig";
$this->load->view("redirect",$data);
}
}
public function deleteconfig()
{
$access=array("1");
$this->checkaccess($access);
$this->config_model->delete($this->input->get("id"));
$data["redirect"]="site/viewconfig";
$this->load->view("redirect",$data);
}
public function viewcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcategory";
$data["base_url"]=site_url("site/viewcategoryjson");
$data["title"]="View category";
$this->load->view("template",$data);
}
function viewcategoryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_category`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`euro_category`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`euro_category`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";
$elements[3]=new stdClass();
$elements[3]->field="`euro_category`.`insideimage`";
$elements[3]->sort="1";
$elements[3]->header="Inside Image";
$elements[3]->alias="insideimage";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_category`");
$this->load->view("json",$data);
}

public function createcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createcategory";
$data["title"]="Create category";
$this->load->view("template",$data);
}
public function createcategorysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("insideimage","Inside Image","trim");
$this->form_validation->set_rules("order","Order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createcategory";
$data["title"]="Create category";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
//$image=$this->input->get_post("image");
//$insideimage=$this->input->get_post("insideimage");
$order=$this->input->get_post("order");
     $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				    $config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$image=$uploaddata['file_name'];
}
$filename="insideimage";
$insideimage="";
if (  $this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$insideimage=$uploaddata['file_name'];
}
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
    
    

    
if($this->category_model->create($name,$image,$insideimage,$order)==0)
$data["alerterror"]="New category could not be created.";
else
$data["alertsuccess"]="category created Successfully.";
$data["redirect"]="site/viewcategory";
$this->load->view("redirect",$data);
}
}
public function editcategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editcategory";
$data["title"]="Edit category";
$data["before"]=$this->category_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editcategorysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("insideimage","Inside Image","trim");
$this->form_validation->set_rules("order","Order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editcategory";
$data["title"]="Edit category";
$data["before"]=$this->category_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$image=$this->input->get_post("image");
$insideimage=$this->input->get_post("insideimage");
$order=$this->input->get_post("order");
    
          $config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image";
$image="";
if ($this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$image=$uploaddata['file_name'];
}
$filename="insideimage";
$insideimage="";
if (  $this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$insideimage=$uploaddata['file_name'];
}
						if (  $this->upload->do_upload($filename))
						{
							$uploaddata = $this->upload->data();
							$image=$uploaddata['file_name'];
						}

						if($image=="")
						{
						$image=$this->category_model->getimagebyid($id);
						   // print_r($image);
							$image=$image->image;
						}
if($this->category_model->edit($id,$name,$image,$insideimage,$order)==0)
$data["alerterror"]="New category could not be Updated.";
else
$data["alertsuccess"]="category Updated Successfully.";
$data["redirect"]="site/viewcategory";
$this->load->view("redirect",$data);
}
}
public function deletecategory()
{
$access=array("1");
$this->checkaccess($access);
$this->category_model->delete($this->input->get("id"));
$data["redirect"]="site/viewcategory";
$this->load->view("redirect",$data);
}
public function viewproduct()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewproduct";
$data["base_url"]=site_url("site/viewproductjson");
$data["title"]="View product";
$this->load->view("template",$data);
}
function viewproductjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_product`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`euro_product`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`euro_product`.`category`";
$elements[2]->sort="1";
$elements[2]->header="Category";
$elements[2]->alias="category";
$elements[3]=new stdClass();
$elements[3]->field="`euro_product`.`order`";
$elements[3]->sort="1";
$elements[3]->header="Order";
$elements[3]->alias="order";
$elements[4]=new stdClass();
$elements[4]->field="`euro_product`.`image`";
$elements[4]->sort="1";
$elements[4]->header="Image";
$elements[4]->alias="image";
$elements[5]=new stdClass();
$elements[5]->field="`euro_product`.`name`";
$elements[5]->sort="1";
$elements[5]->header="Name";
$elements[5]->alias="name";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_product`");
$this->load->view("json",$data);
}

public function createproduct()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createproduct";
$data["title"]="Create product";
$data['category']=$this->product_model->getcategorydropdown();    
$this->load->view("template",$data);
}
public function createproductsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
//$this->form_validation->set_rules("category","Category","trim");
$this->form_validation->set_rules("order","Order","trim");
    $data['category']=$this->product_model->getcategorydropdown();
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("desc","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createproduct";
$data["title"]="Create product";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$category=$this->input->get_post("category");
$order=$this->input->get_post("order");
//$image=$this->input->get_post("image");
$name=$this->input->get_post("name");
$desc=$this->input->get_post("desc");
     $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
if($this->product_model->create($name,$category,$order,$image,$name,$desc)==0)
$data["alerterror"]="New product could not be created.";
else
$data["alertsuccess"]="product created Successfully.";
$data["redirect"]="site/viewproduct";
$this->load->view("redirect",$data);
}
}
public function editproduct()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editproduct";
$data["title"]="Edit product";
$data["before"]=$this->product_model->beforeedit($this->input->get("id"));
    $data['category']=$this->product_model->getcategorydropdown(); 
$this->load->view("template",$data);
}
public function editproductsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("name","Name","trim");
//$this->form_validation->set_rules("category","Category","trim");
    $data['category']=$this->product_model->getcategorydropdown(); 
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("desc","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editproduct";
$data["title"]="Edit product";
$data["before"]=$this->product_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$category=$this->input->get_post("category");
$order=$this->input->get_post("order");
$image=$this->input->get_post("image");
$name=$this->input->get_post("name");
$desc=$this->input->get_post("desc");
                
             $config['upload_path'] = './uploads/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$this->load->library('upload', $config);
						$filename="image";
						$image="";
						if (  $this->upload->do_upload($filename))
						{
							$uploaddata = $this->upload->data();
							$image=$uploaddata['file_name'];
						}

						if($image=="")
						{
						$image=$this->product_model->getimagebyid($id);
						   // print_r($image);
							$image=$image->image;
						}
                        
if($this->product_model->edit($id,$name,$category,$order,$image,$name,$desc)==0)
$data["alerterror"]="New product could not be Updated.";
else
$data["alertsuccess"]="product Updated Successfully.";
$data["redirect"]="site/viewproduct";
$this->load->view("redirect",$data);
}
}
public function deleteproduct()
{
$access=array("1");
$this->checkaccess($access);
$this->product_model->delete($this->input->get("id"));
$data["redirect"]="site/viewproduct";
$this->load->view("redirect",$data);
}
public function viewgallerycategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewgallerycategory";
$data["base_url"]=site_url("site/viewgallerycategoryjson");
$data["title"]="View gallerycategory";
$this->load->view("template",$data);
}
function viewgallerycategoryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_gallerycategory`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`euro_gallerycategory`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`euro_gallerycategory`.`image`";
$elements[2]->sort="1";
$elements[2]->header="Image";
$elements[2]->alias="image";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_gallerycategory`");
$this->load->view("json",$data);
}

public function creategallerycategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="creategallerycategory";
$data["title"]="Create gallerycategory";
$this->load->view("template",$data);
}
public function creategallerycategorysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="creategallerycategory";
$data["title"]="Create gallerycategory";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$image=$this->input->get_post("image");
$order=$this->input->get_post("order");
     $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
    
    
if($this->gallerycategory_model->create($name,$image,$order)==0)
$data["alerterror"]="New gallerycategory could not be created.";
else
$data["alertsuccess"]="gallerycategory created Successfully.";
$data["redirect"]="site/viewgallerycategory";
$this->load->view("redirect",$data);
}
}
public function editgallerycategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editgallerycategory";
$data["title"]="Edit gallerycategory";
$data["before"]=$this->gallerycategory_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editgallerycategorysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image","Image","trim");
$this->form_validation->set_rules("order","Order","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editgallerycategory";
$data["title"]="Edit gallerycategory";
$data["before"]=$this->gallerycategory_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
//$image=$this->input->get_post("image");
$order=$this->input->get_post("order");
                  
             $config['upload_path'] = './uploads/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$this->load->library('upload', $config);
						$filename="image";
						$image="";
						if (  $this->upload->do_upload($filename))
						{
							$uploaddata = $this->upload->data();
							$image=$uploaddata['file_name'];
						}

						if($image=="")
						{
						$image=$this->product_model->getimagebyid($id);
						   // print_r($image);
							$image=$image->image;
						}
                        
if($this->gallerycategory_model->edit($id,$name,$image,$order)==0)
$data["alerterror"]="New gallerycategory could not be Updated.";
else
$data["alertsuccess"]="gallerycategory Updated Successfully.";
$data["redirect"]="site/viewgallerycategory";
$this->load->view("redirect",$data);
}
}
public function deletegallerycategory()
{
$access=array("1");
$this->checkaccess($access);
$this->gallerycategory_model->delete($this->input->get("id"));
$data["redirect"]="site/viewgallerycategory";
$this->load->view("redirect",$data);
}
public function viewgalleryimage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewgalleryimage";
$data["base_url"]=site_url("site/viewgalleryimagejson");
$data["title"]="View galleryimage";
$this->load->view("template",$data);
}
function viewgalleryimagejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_galleryimage`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`euro_galleryimage`.`order`";
$elements[1]->sort="1";
$elements[1]->header="Order";
$elements[1]->alias="order";
$elements[2]=new stdClass();
$elements[2]->field="`euro_galleryimage`.`gallerycategory`";
$elements[2]->sort="1";
$elements[2]->header="Gallery Category";
$elements[2]->alias="gallerycategory";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_galleryimage`");
$this->load->view("json",$data);
}

public function creategalleryimage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="creategalleryimage";
$data["title"]="Create galleryimage";
$this->load->view("template",$data);
}
public function creategalleryimagesubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("gallerycategory","Gallery Category","trim");
$this->form_validation->set_rules("name","Name","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="creategalleryimage";
$data["title"]="Create galleryimage";
$this->load->view("template",$data);
}
else
{
$order=$this->input->get_post("order");
$gallerycategory=$this->input->get_post("gallerycategory");
$name=$this->input->get_post("name");
if($this->galleryimage_model->create($order,$gallerycategory,$name)==0)
$data["alerterror"]="New galleryimage could not be created.";
else
$data["alertsuccess"]="galleryimage created Successfully.";
$data["redirect"]="site/viewgalleryimage";
$this->load->view("redirect",$data);
}
}
public function editgalleryimage()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editgalleryimage";
$data["title"]="Edit galleryimage";
$data["before"]=$this->galleryimage_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editgalleryimagesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("order","Order","trim");
$this->form_validation->set_rules("gallerycategory","Gallery Category","trim");
$this->form_validation->set_rules("name","Name","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editgalleryimage";
$data["title"]="Edit galleryimage";
$data["before"]=$this->galleryimage_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$order=$this->input->get_post("order");
$gallerycategory=$this->input->get_post("gallerycategory");
$name=$this->input->get_post("name");
if($this->galleryimage_model->edit($id,$order,$gallerycategory,$name)==0)
$data["alerterror"]="New galleryimage could not be Updated.";
else
$data["alertsuccess"]="galleryimage Updated Successfully.";
$data["redirect"]="site/viewgalleryimage";
$this->load->view("redirect",$data);
}
}
public function deletegalleryimage()
{
$access=array("1");
$this->checkaccess($access);
$this->galleryimage_model->delete($this->input->get("id"));
$data["redirect"]="site/viewgalleryimage";
$this->load->view("redirect",$data);
}
public function viewenquiry()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewenquiry";
$data["base_url"]=site_url("site/viewenquiryjson");
$data["title"]="View enquiry";
$this->load->view("template",$data);
}
function viewenquiryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_enquiry`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`euro_enquiry`.`status`";
$elements[1]->sort="1";
$elements[1]->header="Status";
$elements[1]->alias="status";
$elements[2]=new stdClass();
$elements[2]->field="`euro_enquiry`.`name`";
$elements[2]->sort="1";
$elements[2]->header="Name";
$elements[2]->alias="name";
$elements[3]=new stdClass();
$elements[3]->field="`euro_enquiry`.`email`";
$elements[3]->sort="1";
$elements[3]->header="Email Id";
$elements[3]->alias="email";
$elements[4]=new stdClass();
$elements[4]->field="`euro_enquiry`.`telephone`";
$elements[4]->sort="1";
$elements[4]->header="Telephone";
$elements[4]->alias="telephone";
$elements[5]=new stdClass();
$elements[5]->field="`euro_enquiry`.`timestamp`";
$elements[5]->sort="1";
$elements[5]->header="Timestamp";
$elements[5]->alias="timestamp";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_enquiry`");
$this->load->view("json",$data);
}

public function createenquiry()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createenquiry";
$data["title"]="Create enquiry";
$this->load->view("template",$data);
}
public function createenquirysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("email","Email Id","trim");
$this->form_validation->set_rules("telephone","Telephone","trim");
$this->form_validation->set_rules("timestamp","Timestamp","trim");
$this->form_validation->set_rules("query","Query","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createenquiry";
$data["title"]="Create enquiry";
$this->load->view("template",$data);
}
else
{
$status=$this->input->get_post("status");
$name=$this->input->get_post("name");
$email=$this->input->get_post("email");
$telephone=$this->input->get_post("telephone");
$timestamp=$this->input->get_post("timestamp");
$query=$this->input->get_post("query");
if($this->enquiry_model->create($status,$name,$email,$telephone,$timestamp,$query)==0)
$data["alerterror"]="New enquiry could not be created.";
else
$data["alertsuccess"]="enquiry created Successfully.";
$data["redirect"]="site/viewenquiry";
$this->load->view("redirect",$data);
}
}
public function editenquiry()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editenquiry";
$data["title"]="Edit enquiry";
$data["before"]=$this->enquiry_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editenquirysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
$this->form_validation->set_rules("status","Status","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("email","Email Id","trim");
$this->form_validation->set_rules("telephone","Telephone","trim");
$this->form_validation->set_rules("timestamp","Timestamp","trim");
$this->form_validation->set_rules("query","Query","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editenquiry";
$data["title"]="Edit enquiry";
$data["before"]=$this->enquiry_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$status=$this->input->get_post("status");
$name=$this->input->get_post("name");
$email=$this->input->get_post("email");
$telephone=$this->input->get_post("telephone");
$timestamp=$this->input->get_post("timestamp");
$query=$this->input->get_post("query");
if($this->enquiry_model->edit($id,$status,$name,$email,$telephone,$timestamp,$query)==0)
$data["alerterror"]="New enquiry could not be Updated.";
else
$data["alertsuccess"]="enquiry Updated Successfully.";
$data["redirect"]="site/viewenquiry";
$this->load->view("redirect",$data);
}
}
public function deleteenquiry()
{
$access=array("1");
$this->checkaccess($access);
$this->enquiry_model->delete($this->input->get("id"));
$data["redirect"]="site/viewenquiry";
$this->load->view("redirect",$data);
}
public function viewhomecategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewhomecategory";
$data["base_url"]=site_url("site/viewhomecategoryjson");
$data["title"]="View homecategory";
$this->load->view("template",$data);
}
function viewhomecategoryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`euro_homecategory`.`id`";
$elements[0]->sort="1";
$elements[0]->header="Id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`euro_homecategory`.`product1`";
$elements[1]->sort="1";
$elements[1]->header="Product1";
$elements[1]->alias="product1";
$elements[2]=new stdClass();
$elements[2]->field="`euro_homecategory`.`product2`";
$elements[2]->sort="1";
$elements[2]->header="Product2";
$elements[2]->alias="product2";
$elements[3]=new stdClass();
$elements[3]->field="`euro_homecategory`.`product3`";
$elements[3]->sort="1";
$elements[3]->header="Product3";
$elements[3]->alias="product3";
$elements[4]=new stdClass();
$elements[4]->field="`euro_homecategory`.`product4`";
$elements[4]->sort="1";
$elements[4]->header="Product4";
$elements[4]->alias="product4";
$elements[5]=new stdClass();
$elements[5]->field="`euro_homecategory`.`name`";
$elements[5]->sort="1";
$elements[5]->header="Name";
$elements[5]->alias="name";
$elements[6]=new stdClass();
$elements[6]->field="`euro_homecategory`.`image1`";
$elements[6]->sort="1";
$elements[6]->header="Image1";
$elements[6]->alias="image1";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `euro_homecategory`");
$this->load->view("json",$data);
}

public function createhomecategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createhomecategory";
$data["title"]="Create homecategory";
	$data['product1']=$this->homecategory_model->getproduct1dropdown(); 
	$data['product2']=$this->homecategory_model->getproduct2dropdown(); 
	$data['product3']=$this->homecategory_model->getproduct3dropdown(); 
	$data['product4']=$this->homecategory_model->getproduct4dropdown(); 
$this->load->view("template",$data);
}
public function createhomecategorysubmit() 
{
$access=array("1");
$this->checkaccess($access);
    	$data['product1']=$this->homecategory_model->getproduct1dropdown();
    	$data['product2']=$this->homecategory_model->getproduct2dropdown();
    	$data['product3']=$this->homecategory_model->getproduct3dropdown();
    	$data['product4']=$this->homecategory_model->getproduct4dropdown();
//$this->form_validation->set_rules("product1","Product1","trim");
//$this->form_validation->set_rules("product2","Product2","trim");
//$this->form_validation->set_rules("product3","Product3","trim");
//$this->form_validation->set_rules("product4","Product4","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image1","Image1","trim");
$this->form_validation->set_rules("imagehover","Image Hover","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createhomecategory";
$data["title"]="Create homecategory";
$this->load->view("template",$data);
}
else
{
$product1=$this->input->get_post("product1");
$product2=$this->input->get_post("product2");
$product3=$this->input->get_post("product3");
$product4=$this->input->get_post("product4");
$name=$this->input->get_post("name");
$image1=$this->input->get_post("image1");
$imagehover=$this->input->get_post("imagehover");
  $config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image1";
$image1="";
if (  $this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$image1=$uploaddata['file_name'];
}
$filename="imagehover";
$imagehover="";
if (  $this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$imagehover=$uploaddata['file_name'];
}
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
    
if($this->homecategory_model->create($product1,$product2,$product3,$product4,$name,$image1,$imagehover)==0)
$data["alerterror"]="New homecategory could not be created.";
else
$data["alertsuccess"]="homecategory created Successfully.";
$data["redirect"]="site/viewhomecategory";
$this->load->view("redirect",$data);
}
}
public function edithomecategory()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="edithomecategory";
$data["title"]="Edit homecategory";
    	$data['product1']=$this->homecategory_model->getproduct1dropdown(); 
	$data['product2']=$this->homecategory_model->getproduct2dropdown(); 
	$data['product3']=$this->homecategory_model->getproduct3dropdown(); 
	$data['product4']=$this->homecategory_model->getproduct4dropdown(); 
$data["before"]=$this->homecategory_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function edithomecategorysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","Id","trim");
	$data['product1']=$this->homecategory_model->getproduct1dropdown(); 
	$data['product2']=$this->homecategory_model->getproduct2dropdown(); 
	$data['product3']=$this->homecategory_model->getproduct3dropdown(); 
	$data['product4']=$this->homecategory_model->getproduct4dropdown(); 
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("image1","Image1","trim");
$this->form_validation->set_rules("imagehover","Image Hover","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="edithomecategory";
$data["title"]="Edit homecategory";
$data["before"]=$this->homecategory_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$product1=$this->input->get_post("product1");
$product2=$this->input->get_post("product2");
$product3=$this->input->get_post("product3");
$product4=$this->input->get_post("product4");
$name=$this->input->get_post("name");
$image1=$this->input->get_post("image1");
$imagehover=$this->input->get_post("imagehover");
    
    
          $config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$this->load->library('upload', $config);
$filename="image1";
$image1="";
if ($this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$image1=$uploaddata['file_name'];
}
$filename="imagehover";
$imagehover="";
if (  $this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$imagehover=$uploaddata['file_name'];
}
						if (  $this->upload->do_upload($filename))
						{
							$uploaddata = $this->upload->data();
							$imagehover=$uploaddata['file_name'];
						}

						if($imagehover=="")
						{
						$imagehover=$this->homecategory_model->getimagebyid($id);
						   // print_r($imagehover);
							$imagehover=$imagehover->imagehover;
						}
if($this->homecategory_model->edit($id,$product1,$product2,$product3,$product4,$name,$image1,$imagehover)==0)
$data["alerterror"]="New homecategory could not be Updated.";
else
$data["alertsuccess"]="homecategory Updated Successfully.";
$data["redirect"]="site/viewhomecategory";
$this->load->view("redirect",$data);
}
}
public function deletehomecategory()
{
$access=array("1");
$this->checkaccess($access);
$this->homecategory_model->delete($this->input->get("id"));
$data["redirect"]="site/viewhomecategory";
$this->load->view("redirect",$data);
}
}
?>
