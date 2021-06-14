<?php

namespace Generic;

class Validation_Functions
{

    private $errors = array();
    private $ci;

    public function errors()
    {
        return $this->errors;
    }

    public function has_errors()
    {
        return count($this->errors) > 0;
    }

    function __construct()
    {
        global $CI;
        $this->ci = $CI;
        $this->ci->load->library('form_validation');
    }

    public function validate_signup_form()
    {
        $validation_array = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required|user_name|max_length[100]'
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'user_name|max_length[100]'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|validate_email_symbols|max_length[100]|validate_email_domain'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[32]'
            ),
            array(
                'field' => 'mobile',
                'label' => 'Mobile',
                'rules' => "required|numeric|max_length[10]"
            ),
            array(
                'field' => 'type',
                'label' => 'Type',
                'rules' => "required|check_enum['buyer','seller']"
            ),
            array(
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => "required|check_enum['Male','Female','Transgender']"
            )
        );
        $this->ci->form_validation->set_rules($validation_array);
        if ($this->ci->form_validation->run() == FALSE) {
            $this->errors = $this->ci->form_validation->_error_array();
        }
    }

    public function validate_login_form()
    {
        $validation_array = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|validate_email_symbols|max_length[100]|validate_email_domain'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[32]'
            ),
        );
        $this->ci->form_validation->set_rules($validation_array);
        if ($this->ci->form_validation->run() == FALSE) {
            $this->errors = $this->ci->form_validation->_error_array();
        }
    }
}
