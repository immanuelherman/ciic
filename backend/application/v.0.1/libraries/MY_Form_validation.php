<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	protected $_strict;

    public function __construct()
    {
        parent::__construct();
    }

    function get_error()
    {
    	return "error";
    }

    /**
	 * By default, form validation uses the $_POST array to validate
	 *
	 * If an array is set through this method, then this array will
	 * be used instead of the $_POST array
	 *
	 * Note that if you are validating multiple arrays, then the
	 * reset_validation() function should be called after validating
	 * each array due to the limitations of CI's singleton
	 *
	 * @param	array	$data
	 * @return	CI_Form_validation
	 */
	public function set_data(array $data, $strict = FALSE)
	{
		$this->_strict = $strict;

		if ( ! empty($data))
		{
			$this->validation_data = $data;
		}

		return $this;
	}

	/**
	 * Run the Validator
	 *
	 * This function does all the work.
	 *
	 * @param	string	$group
	 * @return	bool
	 */
	public function run($group = '')
	{
		if ($this->_strict !== FALSE)
		{
			if (empty($this->validation_data))
			{
				foreach (array_keys($this->_field_data) as $key => $value) 
				{
					$this->validation_data[$value] = NULL;
				}
			}

	        $diff = array_diff(array_keys($this->validation_data), array_keys($this->_field_data));

	        if (!empty($diff))
	        {
		        $this->_error_array = "Bad parameter. parameter not allowed : ".implode(", ", $diff);
		        return FALSE;
	        }
		}
		// Do we even have any data to process?  Mm?
		$validation_array = empty($this->validation_data) ? $_POST : $this->validation_data;
		if (count($validation_array) === 0)
		{
			return FALSE;
		}

		// Does the _field_data array containing the validation rules exist?
		// If not, we look to see if they were assigned via a config file
		if (count($this->_field_data) === 0)
		{
			// No validation rules?  We're done...
			if (count($this->_config_rules) === 0)
			{
				return FALSE;
			}

			if (empty($group))
			{
				// Is there a validation rule for the particular URI being accessed?
				$group = trim($this->CI->uri->ruri_string(), '/');
				isset($this->_config_rules[$group]) OR $group = $this->CI->router->class.'/'.$this->CI->router->method;
			}

			$this->set_rules(isset($this->_config_rules[$group]) ? $this->_config_rules[$group] : $this->_config_rules);

			// Were we able to set the rules correctly?
			if (count($this->_field_data) === 0)
			{
				log_message('debug', 'Unable to find validation rules');
				return FALSE;
			}
		}

		// Load the language file containing error messages
		$this->CI->lang->load('form_validation');

		// Cycle through the rules for each field and match the corresponding $validation_data item
		foreach ($this->_field_data as $field => $row)
		{
			// Fetch the data from the validation_data array item and cache it in the _field_data array.
			// Depending on whether the field name is an array or a string will determine where we get it from.
			if ($row['is_array'] === TRUE)
			{
				$this->_field_data[$field]['postdata'] = $this->_reduce_array($validation_array, $row['keys']);
			}
			elseif (isset($validation_array[$field]) && $validation_array[$field] !== '')
			{
				$this->_field_data[$field]['postdata'] = $validation_array[$field];
			}
		}

		// Execute validation rules
		// Note: A second foreach (for now) is required in order to avoid false-positives
		//	 for rules like 'matches', which correlate to other validation fields.
		foreach ($this->_field_data as $field => $row)
		{
			// Don't try to validate if we have no rules set
			if (empty($row['rules']))
			{
				continue;
			}

			$this->_execute($row, $row['rules'], $this->_field_data[$field]['postdata']);
		}

		// Did we end up with any errors?
		$total_errors = count($this->_error_array);
		if ($total_errors > 0)
		{
			$this->_safe_form_data = TRUE;
		}

		// Now we need to re-set the POST data with the new, processed data
		$this->_reset_post_array();

		return ($total_errors === 0);
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Email
	 *
	 * @param	string
	 * @return	bool
	 */
	public function valid_email($str)
	{
		return valid_email($str);
	}


	public function valid_emails($str)
	{
		if (strpos($str, ',') === FALSE)
		{
			return valid_email(trim($str));
		}

		foreach (explode(',', $str) as $email)
		{
			if (trim($email) !== '' && valid_email(trim($email)) === FALSE)
			{
				return FALSE;
			}
		}

		return TRUE;
	}
}