<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application structure built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

class Validator {

    /*
    |--------------------------------------------------------------------------
    | Public
    |--------------------------------------------------------------------------
    */

    public function run($template, $action, $postsToIgnore = array())
    {
        switch ($action)
        {
            case 'validate':
                return $this->validate($template, $postsToIgnore);
                break;

            case 'prepare':
                return $this->prepareTheModel($template, $postsToIgnore);
                break;

            default:
                return $this->validate($template, $postsToIgnore);
                break;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Private
    |--------------------------------------------------------------------------
    */

    private function getTemplate($template)
    {
        return json_decode(file_get_contents("application/models/templates/".$template.".json"));
    }

    private function validate($template, $postsToIgnore)
    {
        $CI =& get_instance();
        $CI->load->library("sanity");

        $errors = array();

        $fields = $this->getTemplate($template);

        foreach ($fields as $field)
        {
            if ( ! in_array($field->name, $postsToIgnore))
            {
                if ($field->required)
                {
                    if ($CI->input->post($field->name) == "" && ! in_array($field->error, $errors))
                    {
                        array_push($errors, $field->error);
                    }
                }

                if ( ! $CI->sanity->test_result($CI->input->post($field->name), "is_".$field->type) && ! in_array($field->error, $errors))
                {
                    array_push($errors, $field->error);
                }

                if ( ! in_array($field->error, $errors))
                {
                    if (strlen($CI->input->post($field->name)) < $field->length) array_push($errors, $field->error);
                }
            }
        }

        if (count($errors) > 0) return array("valid" => false, "error" => implode(", ", $errors));

        return array("valid" => true);
    }
    /**
     * Poulates an input model with key value relations
     *
     * @return array
     */
    public function prepareTheModel($template, $postsToIgnore)
    {
        $CI =& get_instance();

        $fields = $this->getTemplate($template);
        $inputData = array();

        foreach ($fields as $field)
        {
            if ( ! in_array($field->name, $postsToIgnore))
            {
                if ($CI->input->post($field->name))
                {
                    $inputData[$field->db_name] = $CI->input->post($field->name);
                }
            }
        }

        return $inputData;
    }
}
//End of File
?>