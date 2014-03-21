<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class blog_categories extends MX_Controller {

    public function check_title()
    {
        $this->load->model('model_blog_categories');
        $qry = $this->model_blog_categories->check_title($this->input->post('cat_name'), "blog");

        if ($qry == 'fail') echo $qry;

        else echo 'success';
    }

    public function add($type)
    {
        $this->load->model('model_blog_categories');
        $qry = $this->model_blog_categories->add_category($this->input->post('cat_name'), $this->input->post('cat_parent'));

        if ($qry) return true;
    }

    public function delete($type)
    {
        $this->load->model('model_blog_categories');
        $qry = $this->model_blog_categories->delete_category($this->input->post('cat_id'));

        if($qry) echo 'success';
        else echo 'failed';
    }

    public function view()
    {
        $this->load->model('model_blog_categories');
        $categories = $this->model_blog_categories->get_all_cats();

        foreach($categories as $item)
        {
            if ($item->cat_parent == 0)
            {
                echo '<button data-role="button" data-theme="e" data-icon="delete" onclick="deleteCat('.$item->cat_id.', \''.site_url('categories/delete/').'\')">'.$item->cat_title.'</button>';
                $this->getKids($item->cat_id, 0);
            }
        }
    }

    public function getKids($cat_parent_id, $level){
        $this->load->model('model_blog_categories');
        $categories = $this->model_blog_categories->get_all_cats();

        $color = $this->color($level);

        foreach ($categories as $item):
            if ($item->cat_parent == $cat_parent_id){
                echo '<button data-role="button" data-theme="e" data-icon="delete" onclick="deleteCat('.$item->cat_id.', \''.site_url('categories/delete/').'\')">'.$item->cat_title.'</button>';
                $level++;
                $this->getKids($item->cat_id, $level);
            }
        endforeach;
    }

    public function color($level)
    {
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

    public function options($id)
    {
        $this->load->model('model_blog_categories');
        $categories = $this->model_blog_categories->get_all_cats();

        if (is_null($id) || $id == "null") echo '<option value="">Please Select a Category</option>';
        else
        {
            $cat = $this->model_blog_categories->get_a_cat($id);
            echo '<option value="'.$cat[0]->cat_id.'">Currently: '.$cat[0]->cat_title.'</option>';
        }

        foreach($categories as $item)
        {
            if ($item->cat_parent == 0)
            {
                echo '<option value="'.$item->cat_id.'">'.$item->cat_title.'</option>';
                $this->getOptionKids($item->cat_id, 0);
            }
        }
    }

    public function parent_options($type)
    {
        $this->load->model('model_blog_categories');
        $categories = $this->model_blog_categories->get_all_cats();

        echo '<option value="">Please Select a Parent</option>';
        echo '<option value="">None</option>';

        foreach($categories as $item)
        {
            if ($item->cat_parent == 0) {
                echo '<option value="'.$item->cat_id.'">'.$item->cat_title.'</option>';
                $this->getOptionKids($item->cat_id);
            }
        }
    }

    public function getOptionKids($parent_id)
    {
        $this->load->model('model_blog_categories');
        $categories = $this->model_blog_categories->get_all_cats();

        foreach($categories as $item)
        {
            if ($item->cat_parent == $parent_id)
            {
                echo '<option value="'.$item->cat_id.'">'.$item->cat_title.'</option>';
                $this->getOptionKids($item->cat_id);
            }
        }
    }

    public function update_options()
    {
        $this->load->model('model_blog_categories');
        $categories = $this->model_blog_categories->get_all_cats();

        foreach($categories as $item)
        {
            echo '<option value="'.$item->cat_id.'">'.$item->cat_title.'</option>';
        }
    }

}
/* End of file blog_categories.php */
/* Location: ./application/controllers/ */