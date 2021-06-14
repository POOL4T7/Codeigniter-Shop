<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{

    function __construct()
    {
        parent::__construct();
    }

    public function _error_array()
    {
        return $this->_error_array;
    }

    public function empty_error_array()
    {
        $this->_error_array = array();
    }

    function url_check($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return TRUE;
        } else {
            $this->set_message('url_check', 'The %s field is not a valid url');
            return FALSE;
        }
    }

    function user_name($str)
    {
        if (preg_match("/^([a-zA-Z .])+$/i", $str)) {
            return TRUE;
        } else {
            $this->set_message('user_name', 'The %s field is not a valid name');
            return FALSE;
        }
    }

    function validate_email_symbols($email)
    {
        $email_splited = explode("@", $email);
        $email_suffix = $email_splited[0];
        $email_prefix = $email_splited[1];
        if (strpos($email_prefix, "Project.com") !== FALSE) {
            return TRUE;
        } else {
            if (strpos($email_suffix, "+") !== FALSE) {
                $this->set_message('validate_email_symbols', 'Please enter a valid email id');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    function url_validate($url)
    {
        //diegoperini regex url match
        $pattern = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS';
        $is_valid_url = preg_match($pattern, $url);
        if ($is_valid_url) {
            return TRUE;
        } else {
            $this->set_message('url_validate', 'The %s field is not a valid url');
            return FALSE;
        }
    }

    function country_code_check($country_code)
    {
        if (preg_match('/^[\+][0-9]{1,5}$/', $country_code) && strlen($country_code) <= 5) {
            return TRUE;
        } else {
            $this->set_message('country_code_check', 'The %s field is not a valid country code');
            return FALSE;
        }
    }

    function phone_number_check($phone_number, $country_code = FALSE)
    {
        if ($country_code && $country_code != '+91') {
            return TRUE;
        }
        if (preg_match('/^[6789][0-9]{9}$/', $phone_number)) {
            return TRUE;
        } else {
            $this->set_message('phone_number_check', 'The %s field is not a valid phone number');
            return FALSE;
        }
    }

    function max_words($field, $length)
    {
        $words = count(explode(' ', $field));
        if ($words > $length) {
            $this->set_message('max_words', 'The %s field cannot exceed ' . $length . ' words in length');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function size($file, $size)
    {
        if ($file['error'] != 1) {
            if ($file['size'] <= $size) {
                return TRUE;
            } else {
                $this->set_message('size', 'The %s field size must be less than or equal to  ' . $size / (1024 * 1024) . ' MB');
                return FALSE;
            }
        } else {
            $this->set_message('size', 'There is problem in uploading file');
            return FALSE;
        }
    }

    function less_than_equal_to($field, $value)
    {
        if ($field <= $value) {
            return TRUE;
        } else {
            $this->set_message('less_than_equal_to', 'The %s field must be less than or equal to ' . $value);
            return FALSE;
        }
    }

    function greater_than_equal_to($field, $value)
    {
        if ($field >= $value) {
            return TRUE;
        } else {
            $this->set_message('greater_than_equal_to', 'The %s field must be greater than or equal to ' . $value);
            return FALSE;
        }
    }

    function equal_to($field, $value)
    {
        if ($field == $value) {
            return TRUE;
        } else {
            $this->set_message('equal_to', 'The %s field must be equal to ' . $value);
            return FALSE;
        }
    }

    function check_enum($field, $enum)
    {
        $enum_array = explode(":", $enum);
        if (in_array($field, $enum_array)) {
            return TRUE;
        } else {
            $this->set_message('check_enum', 'The %s field is invalid');
            return FALSE;
        }
    }

    function valid_date($date)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {

            return true;
        } else {
            $this->set_message('valid_date', 'The %s field is not in a valid date format (yyyy-mm-dd)');
            return false;
        }
    }

    function valid_date_time($date)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])( )([0-2][0-4]):([0-5][0-9]):([0-5][0-9])$/", $date)) {

            return true;
        } else {
            $this->set_message('valid_date_time', 'The %s field is not in a valid date format (yyyy-mm-dd H:i:s)');
            return false;
        }
    }

    function real_valid_date_time($string)
    {
        if (DateTime::createFromFormat('Y-m-d H:i:s', $string)) {
            return TRUE;
        }
        $this->set_message('real_valid_date_time', 'The %s field is not in a valid date format (yyyy-mm-dd H:i:s)');
        return FALSE;
    }

    function real_min_date_time($input, $min_date_time_param)
    {
        $input_datetime = new \DateTime($input);
        $min_datetime = new \DateTime($min_date_time_param);
        if ($input_datetime <= $min_datetime) {
            $this->set_message('real_min_date_time', 'The %s field must be greater than ' . $min_date_time_param);
            return FALSE;
        }
        return TRUE;
    }

    function real_max_date_time($input, $max_date_time_param)
    {
        $input_datetime = new \DateTime($input);
        $max_datetime = new \DateTime($max_date_time_param);
        if ($input_datetime >= $max_datetime) {
            $this->set_message('real_max_date_time', 'The %s field must be less than ' . $max_date_time_param);
            return FALSE;
        }
        return TRUE;
    }

    function max_date($date, $max_date_values)
    {
        $max_date_array = explode(":", $max_date_values);
        foreach ($max_date_array as $max_date) {
            if ($max_date < $date) {
                $this->set_message('max_date', 'The %s field should be smaller than or equal to ' . $max_date);
                return FALSE;
            }
        }
        return TRUE;
    }

    function min_date($date, $min_date_values)
    {
        $min_date_array = explode(":", $min_date_values);
        foreach ($min_date_array as $min_date) {
            if ($min_date <= $date) {
                return TRUE;
            } else {
                $this->set_message('min_date', 'The %s field should be greater than or equal to ' . $min_date);
                return false;
            }
        }
    }

    function array_required($field)
    {
        if (strlen($field) == 0 || empty($field)) {
            $this->set_message('array_required', 'The %s field is invalid');
            return false;
        } else {
            return TRUE;
        }
    }

    function check_duplicate($field)
    {
        $field_array = explode(",", $field);
        $duplicate_values = array_unique(array_diff_assoc($field_array, array_unique($field_array)));
        if (count($duplicate_values) > 0) {
            $this->set_message('check_duplicate', 'The %s field have duplicate values');
            return false;
        } else {
            return TRUE;
        }
    }

    function max_length_multivalue($field, $max_value)
    {
        $length_exceeded = 0;
        $field_array = explode(",", $field);
        foreach ($field_array as $field_value) {
            if (strlen($field_value) > $max_value) {
                $this->set_message('max_length_multivalue', 'The %s field values can have maximum length of' . $max_value);
                $length_exceeded = 1;
                break;
            }
        }
        if ($length_exceeded) {
            return False;
        } else {
            return True;
        }
    }

    /**
     * Run the Validator
     *
     * This function does all the work.
     *
     * @access    public
     * @return    bool
     */
    /* function run($group = '') {
      // Do we even have any data to process?  Mm?
      if (count($_POST) == 0 && count($_FILES) == 0) {
      $this->_error_array['no_input'] = 'Input not recieved, please fill form again and submit';
      return FALSE;
      }

      // Does the _field_data array containing the validation rules exist?
      // If not, we look to see if they were assigned via a config file
      if (count($this->_field_data) == 0) {
      // No validation rules?  We're done...
      if (count($this->_config_rules) == 0) {
      return FALSE;
      }

      // Is there a validation rule for the particular URI being accessed?
      $uri = ($group == '') ? trim($this->CI->uri->ruri_string(), '/') : $group;

      if ($uri != '' AND isset($this->_config_rules[$uri])) {
      $this->set_rules($this->_config_rules[$uri]);
      } else {
      $this->set_rules($this->_config_rules);
      }

      // We're we able to set the rules correctly?
      if (count($this->_field_data) == 0) {
      log_message('debug', "Unable to find validation rules");
      return FALSE;
      }
      }

      // Load the language file containing error messages
      $this->CI->lang->load('form_validation');

      // Cycle through the rules for each field, match the
      // corresponding $_POST or $_FILES item and test for errors
      foreach ($this->_field_data as $field => $row) {
      // Fetch the data from the corresponding $_POST or $_FILES array and cache it in the _field_data array.
      // Depending on whether the field name is an array or a string will determine where we get it from.

      if ($row['is_array'] == TRUE) {

      if (isset($_FILES[$field])) {
      $this->_field_data[$field]['postdata'] = $this->_reduce_array($_FILES, $row['keys']);
      } else {
      $this->_field_data[$field]['postdata'] = $this->_reduce_array($_POST, $row['keys']);
      }
      } else {
      if (isset($_POST[$field]) AND $_POST[$field] != "") {
      $this->_field_data[$field]['postdata'] = $_POST[$field];
      } else if (isset($_FILES[$field]) AND $_FILES[$field] != "") {
      $this->_field_data[$field]['postdata'] = $_FILES[$field];
      }
      }

      $this->_execute($row, $row['rules'], $this->_field_data[$field]['postdata']);
      //            $this->_execute($row, explode('|', $row['rules']), $this->_field_data[$field]['postdata']);
      }

      // Did we end up with any errors?
      $total_errors = count($this->_error_array);

      if ($total_errors > 0) {
      $this->_safe_form_data = TRUE;
      }

      // Now we need to re-set the POST data with the new, processed data
      $this->_reset_post_array();

      // No errors, validation passes!
      if ($total_errors == 0) {
      return TRUE;
      }

      // Validation fails
      return FALSE;
      } */

    // --------------------------------------------------------------------

    /**
     * Run the Validator
     *
     * This function does all the work.
     *
     * @param    string $group
     * @return    bool
     */
    public function run($group = '')
    {
        // Do we even have any data to process?  Mm?
        if (count($_POST) == 0 && count($_FILES) == 0) {
            $this->_error_array['no_input'] = 'Input not recieved, please fill form again and submit';
            return FALSE;
        }

        $validation_array = empty($this->validation_data) ? $_POST : $this->validation_data;

        // Does the _field_data array containing the validation rules exist?
        // If not, we look to see if they were assigned via a config file
        if (count($this->_field_data) === 0) {
            // No validation rules?  We're done...
            if (count($this->_config_rules) === 0) {
                return FALSE;
            }

            if (empty($group)) {
                // Is there a validation rule for the particular URI being accessed?
                $group = trim($this->CI->uri->ruri_string(), '/');
                isset($this->_config_rules[$group]) or $group = $this->CI->router->class . '/' . $this->CI->router->method;
            }

            $this->set_rules(isset($this->_config_rules[$group]) ? $this->_config_rules[$group] : $this->_config_rules);

            // Were we able to set the rules correctly?
            if (count($this->_field_data) === 0) {
                log_message('debug', 'Unable to find validation rules');
                return FALSE;
            }
        }

        // Load the language file containing error messages
        $this->CI->lang->load('form_validation');

        // Cycle through the rules for each field and match the corresponding $validation_data item
        foreach ($this->_field_data as $field => &$row) {
            // Fetch the data from the validation_data array item and cache it in the _field_data array.
            // Depending on whether the field name is an array or a string will determine where we get it from.
            /* if ($row['is_array'] === TRUE) {
              $this->_field_data[$field]['postdata'] = $this->_reduce_array($validation_array, $row['keys']);
              } elseif (isset($validation_array[$field])) {
              $this->_field_data[$field]['postdata'] = $validation_array[$field];
              } */
            if ($row['is_array'] == TRUE) {

                if (isset($_FILES[$field])) {
                    $this->_field_data[$field]['postdata'] = $this->_reduce_array($_FILES, $row['keys']);
                } else {
                    $this->_field_data[$field]['postdata'] = $this->_reduce_array($_POST, $row['keys']);
                }
            } else {
                if (isset($_POST[$field]) and $_POST[$field] != "") {
                    $this->_field_data[$field]['postdata'] = $_POST[$field];
                } else if (isset($_FILES[$field]) and $_FILES[$field] != "") {
                    $this->_field_data[$field]['postdata'] = $_FILES[$field];
                }
            }
        }

        // Execute validation rules
        // Note: A second foreach (for now) is required in order to avoid false-positives
        //	 for rules like 'matches', which correlate to other validation fields.
        foreach ($this->_field_data as $field => &$row) {
            // Don't try to validate if we have no rules set
            if (empty($row['rules'])) {
                continue;
            }

            $this->_execute($row, $row['rules'], $row['postdata']);
        }

        // Did we end up with any errors?
        $total_errors = count($this->_error_array);
        if ($total_errors > 0) {
            $this->_safe_form_data = TRUE;
        }

        // Now we need to re-set the POST data with the new, processed data
        empty($this->validation_data) && $this->_reset_post_array();

        return ($total_errors === 0);
    }

    // --------------------------------------------------------------------

    /**
     * Alpha
     *
     * @access    public
     * @param    string
     * @return    bool
     */
    function alpha($str)
    {
        return (!preg_match("/^([a-zA-Z ])+$/i", $str)) ? FALSE : TRUE;
    }

    /**
     * Executes the Validation routines
     *
     * @param	array
     * @param	array
     * @param	mixed
     * @param	int
     * @return	mixed
     */
    protected function _execute($row, $rules, $postdata = NULL, $cycles = 0)
    {
        // If the $_POST data is an array we will run a recursive call
        //
        // Note: We MUST check if the array is empty or not!
        //       Otherwise empty arrays will always pass validation.
        if (is_array($postdata) && !empty($postdata)) {
            foreach ($postdata as $key => $val) {
                $this->_execute($row, $rules, $val, $key);
            }

            return;
        }

        // If the field is blank, but NOT required, no further tests are necessary
        $callback = FALSE;
        if (!in_array('required', $rules) && ($postdata === NULL or $postdata === '')) {
            // Before we bail out, does the rule contain a callback?
            foreach ($rules as &$rule) {
                if (is_string($rule)) {
                    if (strncmp($rule, 'callback_', 9) === 0) {
                        $callback = TRUE;
                        $rules = array(1 => $rule);
                        break;
                    }
                } elseif (is_callable($rule)) {
                    $callback = TRUE;
                    $rules = array(1 => $rule);
                    break;
                } elseif (is_array($rule) && isset($rule[0], $rule[1]) && is_callable($rule[1])) {
                    $callback = TRUE;
                    $rules = array(array($rule[0], $rule[1]));
                    break;
                }
            }

            if (!$callback) {
                return;
            }
        }

        // Isset Test. Typically this rule will only apply to checkboxes.
        if (($postdata === NULL or $postdata === '') && !$callback) {
            if (in_array('isset', $rules, TRUE) or in_array('required', $rules)) {
                // Set the message type
                $type = in_array('required', $rules) ? 'required' : 'isset';

                $line = $this->_get_error_message($type, $row['field']);

                // Build the error message
                $message = $this->_build_error_msg($line, $this->_translate_fieldname($row['label']));

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $message;

                if (!isset($this->_error_array[$row['field']])) {
                    $this->_error_array[$row['field']] = $message;
                }
            }

            return;
        }

        // --------------------------------------------------------------------
        // Cycle through each rule and run it
        foreach ($rules as $rule) {
            $_in_array = FALSE;

            // We set the $postdata variable with the current data in our master array so that
            // each cycle of the loop is dealing with the processed data from the last cycle
            if ($row['is_array'] === TRUE && is_array($this->_field_data[$row['field']]['postdata'])) {
                // We shouldn't need this safety, but just in case there isn't an array index
                // associated with this cycle we'll bail out
                if (!isset($this->_field_data[$row['field']]['postdata'][$cycles])) {
                    continue;
                }

                $postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
                $_in_array = TRUE;
            } else {
                // If we get an array field, but it's not expected - then it is most likely
                // somebody messing with the form on the client side, so we'll just consider
                // it an empty field
                //				$postdata = is_array($this->_field_data[$row['field']]['postdata'])
                //					? NULL
                //					: $this->_field_data[$row['field']]['postdata'];

                $postdata = $this->_field_data[$row['field']]['postdata'];
            }

            // Is the rule a callback?
            $callback = $callable = FALSE;
            if (is_string($rule)) {
                if (strpos($rule, 'callback_') === 0) {
                    $rule = substr($rule, 9);
                    $callback = TRUE;
                }
            } elseif (is_callable($rule)) {
                $callable = TRUE;
            } elseif (is_array($rule) && isset($rule[0], $rule[1]) && is_callable($rule[1])) {
                // We have a "named" callable, so save the name
                $callable = $rule[0];
                $rule = $rule[1];
            }

            // Strip the parameter (if exists) from the rule
            // Rules can contain a parameter: max_length[5]
            $param = FALSE;
            if (!$callable && preg_match('/(.*?)\[(.*)\]/', $rule, $match)) {
                $rule = $match[1];
                $param = $match[2];
            }

            // Call the function that corresponds to the rule
            if ($callback or $callable !== FALSE) {
                if ($callback) {
                    if (!method_exists($this->CI, $rule)) {
                        log_message('debug', 'Unable to find callback validation rule: ' . $rule);
                        $result = FALSE;
                    } else {
                        // Run the function and grab the result
                        $result = $this->CI->$rule($postdata, $param);
                    }
                } else {
                    $result = is_array($rule) ? $rule[0]->{$rule[1]}($postdata) : $rule($postdata);

                    // Is $callable set to a rule name?
                    if ($callable !== FALSE) {
                        $rule = $callable;
                    }
                }

                // Re-assign the result to the master data array
                if ($_in_array === TRUE) {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                } else {
                    $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                }

                // If the field isn't required and we just processed a callback we'll move on...
                if (!in_array('required', $rules, TRUE) && $result !== FALSE) {
                    continue;
                }
            } elseif (!method_exists($this, $rule)) {
                // If our own wrapper function doesn't exist we see if a native PHP function does.
                // Users can use any native PHP function call that has one param.
                if (function_exists($rule)) {
                    // Native PHP functions issue warnings if you pass them more parameters than they use
                    $result = ($param !== FALSE) ? $rule($postdata, $param) : $rule($postdata);

                    if ($_in_array === TRUE) {
                        $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                    } else {
                        $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                    }
                } else {
                    log_message('debug', 'Unable to find validation rule: ' . $rule);
                    $result = FALSE;
                }
            } else {
                $result = $this->$rule($postdata, $param);

                if ($_in_array === TRUE) {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = is_bool($result) ? $postdata : $result;
                } else {
                    $this->_field_data[$row['field']]['postdata'] = is_bool($result) ? $postdata : $result;
                }
            }

            // Did the rule test negatively? If so, grab the error.
            if ($result === FALSE) {
                // Callable rules might not have named error messages
                if (!is_string($rule)) {
                    $line = $this->CI->lang->line('form_validation_error_message_not_set') . '(Anonymous function)';
                } else {
                    $line = $this->_get_error_message($rule, $row['field']);
                }

                // Is the parameter we are inserting into the error message the name
                // of another field? If so we need to grab its "field label"
                if (isset($this->_field_data[$param], $this->_field_data[$param]['label'])) {
                    $param = $this->_translate_fieldname($this->_field_data[$param]['label']);
                }

                // Build the error message
                $message = $this->_build_error_msg($line, $this->_translate_fieldname($row['label']), $param);

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $message;

                if (!isset($this->_error_array[$row['field']])) {
                    $this->_error_array[$row['field']] = $message;
                }

                return;
            }
        }
    }

    function validate_email_domain($email)
    {
        $email_splited = explode("@", $email);
        $email_domain = $email_splited[1];
        if ($email_domain == 'gkv.ac.in') {
            return true;
        } else {
            $this->set_message('validate_email_domain', 'Please enter a email id with gkv domain');
            return false;
        }
    }
}
