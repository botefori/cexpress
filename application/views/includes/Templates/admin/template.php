<?php 
 $output=$this->load->view($membersHeader,'',true);
 $output.=$this->load->view($main_content,$reposit_data,true);
 $output.=$this->load->view($membersFooter,'',true);
 $this->output->set_output($output);
 ?>