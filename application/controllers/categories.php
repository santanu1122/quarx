<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class categories extends CI_Controller {

/* Check for Duplicates 
*************************************/
    function check_title(){
        if($_POST){
            $this->load->model('modelcategories');
            $qry = $this->modelcategories->check_title($_POST['cat_name'], $_POST['cat_type']);
        
            if($qry == 'fail'){
                echo $qry;
            }else{
                echo 'success';
            }
        }
    }

/* Add 
*************************************/
    function add($type){
        if($_POST){
            $this->load->model('modelcategories');
            $qry = $this->modelcategories->add_category($_POST['cat_name'], $_POST['cat_type'], $_POST['cat_parent']);
        
            if($qry){
                return true;
            }
        }
    }

/* Delete
*************************************/
    function delete($type){
        if($_POST){
            $this->load->model('modelcategories');
            $qry = $this->modelcategories->delete_category($_POST['cat_id'], $_POST['cat_type']);
        
            if($qry){
                echo 'success';
            }else{
                echo 'failed';
            }
        }
    }

/* View
*************************************/
    function view($type){
        $this->load->model('modelcategories');
        $categories = $this->modelcategories->get_all_cats($type);

        foreach($categories as $item):
            if($type == 'blog'){
                if($i % 2 == 1){
                    $odd = "style='background: #fff;'";
                }else{
                    $odd = "";
                }
            }

            if($item->cat_parent == 0){
                echo    '<div class="leftBox catBox fat parent" '.$odd.'>
                            <p class="catTitle"><b>'.$item->cat_title.'</b></p>
                            <div class="xclass ui-icon ui-icon-circle-close" onclick="deleteCat('.$item->cat_id.', \''.$type.'\', \''.site_url('categories/delete/'.$type).'\')"></div>
                        </div>';
                $i++;
                $this->getKids($type, $item->cat_id, 0);
            }
        endforeach;
    }

    function getKids($type, $cat_parent_id, $level){
        $this->load->model('modelcategories');
        $categories = $this->modelcategories->get_all_cats($type);

        $color = $this->color($level);

        foreach ($categories as $item):
            if($item->cat_parent == $cat_parent_id){
                echo    '<div class="leftBox catBox fat child" style="background: '.$color.'">
                            <p class="catTitle"><b>'.$item->cat_title.'</b></p>
                            <div class="xclass ui-icon ui-icon-circle-close" onclick="deleteCat('.$item->cat_id.', \''.$type.'\', \''.site_url('categories/delete/'.$type).'\')"></div>
                        </div>';
                $level++;
                $this->getKids($type, $item->cat_id, $level);
            }
        endforeach;
    }

    function color($level) {
        switch ($level) {
            case 24 : $color = "#000c14"; break;
            case 23 : $color = "#001829"; break;
            case 22 : $color = "#00253d"; break;
            case 21 : $color = "#003152"; break;
            case 20 : $color = "#003d66"; break;
            case 19 : $color = "#00497a"; break;
            case 18 : $color = "#00568f"; break;
            case 17 : $color = "#0062a3"; break;
            case 16 : $color = "#006eb8"; break;
            case 15 : $color = "#007acc"; break;
            case 14 : $color = "#0087e0"; break;
            case 13 : $color = "#0093f5"; break;
            case 12 : $color = "#0a9dff"; break;
            case 11 : $color = "#1fa5ff"; break;
            case 10 : $color = "#33adff"; break;
            case 9 : $color = "#47b6ff"; break;
            case 8 : $color = "#5cbeff"; break;
            case 7 : $color = "#70c6ff"; break;
            case 6 : $color = "#85ceff"; break;
            case 5 : $color = "#99d6ff"; break;
            case 4 : $color = "#addeff"; break;
            case 3 : $color = "#c2e7ff"; break;
            case 2 : $color = "#d6efff"; break;
            case 1 : $color = "#ebf7ff"; break;
            case 0 : $color = "#ffffff"; break;
        }
        return $color;
    }

    function options($type){
        $this->load->model('modelcategories');
        $categories = $this->modelcategories->get_all_cats($type);
            echo    '<option value="">Please Select a Category</option>';
        foreach($categories as $item):
            if($item->cat_parent == 0){
                echo    '<option value="'.$item->cat_id.'">'.$item->cat_title.'</option>';
                $this->getOptionKids($type, $item->cat_id, 0);
            }
        endforeach;
    }

    function parent_options($type){
        $this->load->model('modelcategories');
        $categories = $this->modelcategories->get_all_cats($type);
            echo    '<option value="">Please Select a Parent</option>';
            echo    '<option value="">None</option>';
        foreach($categories as $item):
            if($item->cat_parent == 0){
                echo    '<option value="'.$item->cat_id.'">'.$item->cat_title.'</option>';
                $this->getOptionKids($type, $item->cat_id);
            }
        endforeach;
    }

    function getOptionKids($type, $parent_id){
        $this->load->model('modelcategories');
        $categories = $this->modelcategories->get_all_cats($type);
        foreach($categories as $item):
            if($item->cat_parent == $parent_id){
                echo    '<option value="'.$item->cat_id.'">'.$item->cat_title.'</option>';
                $this->getOptionKids($type, $item->cat_id);
            }
        endforeach;
    }
    
    function update_options($type){
        $this->load->model('modelcategories');
        $categories = $this->modelcategories->get_all_cats($type);
        foreach($categories as $item):
            echo    '<option value="'.$item->cat_id.'">'.$item->cat_title.'</option>';
        endforeach;
    }

}
/* End of file plugins.php */
/* Location: ./application/controllers/ */