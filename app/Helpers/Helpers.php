<?php

/**
 * Validate if a received parameter is a null or empty value
 *
 * @param $data - Data to be validated 
 * @return Boolean True (Yes, it is a null or empty value)
 * @return Boolean False (Mo, it is not a null or empty value)
*/
function is_it_null_or_empty($data = null) {
    if (is_array($data))
    { $data = array_filter($data); }

    if ((empty($data)))
    {  return true;  }
    
    if ((!isset($data)))
    {  return true;  }

    if ((is_null($data)))
    {  return true;  }
    
    if ($data === "null" || $data === "NULL" || $data === "Null")
    {  return true;  }
        
    if (ctype_space($data))
    {  return true;  }
    
    if ($data === "undefined")
    {  return true;  }

    return false;
}

/**
 * Validate if a received parameter is not null and also validate if this parameter is of a specific type
 *
 * @param $data - Data to be validated 
 * @param $data_type - Type of the value that is expected to be ['string', 'numeric', 'integer', 'float', 'hour', 'date', 'boolean']
 * @return Value When validate success, the $data value is returned
 * @return Null When validate fail, null is returned
*/
function validate_data($data = null, $data_type = null) {
    $data_type_array = ['string', 'numeric', 'integer', 'float', 'hour', 'date', 'boolean', 'numeric_array'];

    if (is_it_null_or_empty($data))  //Verificar si $data es nulo o vacio
    {  return null;  }

    if (is_it_null_or_empty($data_type))  //No enviaron $data_type => retornamos el valor, ya que no es un nulo o vacio
    {  return $data;  }

    if (in_array(strtolower($data_type), $data_type_array)) {
        switch ($data_type) {
            case 'string':
                if (is_string($data))       {  return $data; }
                else                        {  return null;  }
            break;

            case 'numeric':
                if ( is_numeric($data) )    {  return $data; }
                else                        {  return null;  }
            break;

            case 'integer':
                if ( !(is_numeric($data)) ) {  return null;  }

                $data = intval($data);
                if ( is_int($data))         {  return $data; }
                else                        {  return null;  }
            break;

            case 'float':
                if ( !(is_numeric($data)) ) {  return null;  }

                $data = floatval($data);
                if ( is_float($data))       {  return $data; }
                else                        {  return null;  }
            break;

            // case 'hour':
            // break;

            // case 'date':
            // break;

            case 'boolean':
                if (is_bool($data))         {  return $data; }
                else                        {  return null;  }
            break;

            case 'integer_array':
                if (is_array($data)) {
                    foreach ($data as $key => $number) {
                        if ( !(is_numeric($number)) || !(is_int(intval($number))) ) {
                            unset($data[$key]);
                            $data = array_values($data);
                        }
                    }

                    return $data;
                } else
                {  return null;  }
            break;

            case 'numeric_array':
                if (is_array($data)) {
                    foreach ($data as $key => $number) {
                        if ( !(is_numeric($number)) ) {
                            unset($data[$key]);
                            $data = array_values($data);
                        }
                    }

                    return $data;
                } else
                {  return null;  }
            break;

            case 'string_array':
                if (is_array($data)) {
                    foreach ($data as $key => $string) {
                        if ( !(is_string($string)) ) {
                            unset($data[$key]);
                            $data = array_values($data);
                        }
                    }

                    return $data;
                } else
                { return null; }
            break;
        }
    }
    return $data;
}


/**
 * Store File
 *
 * @param File $file
 * @param String $filesystem_storage_root
 * @return Object
*/
function store_file($file = null, $filesystem_storage_root = null)
{
    if (is_it_null_or_empty($file) || is_it_null_or_empty($filesystem_storage_root))
    { return ['result'  => false, 'message' => 'Make sure you are sending both parameters (file and root filesystem) correctly.']; }

    if (is_it_null_or_empty(config('filesystems.disks')[$filesystem_storage_root]))
    { return ['result'  => false, 'message' => 'Root filesystem do not exist.']; }

    try {
        $file_name = Storage::disk($filesystem_storage_root)->put('/', $file);
        return ['result' => true, 'message' => $file_name];
    } catch (\Exception $exception) {
        Log::info($eexception->getMessage());
        return [
            'result'  => false,
            'message' => $exception->getMessage(),
        ]; 
    }
}

/**
 * Check if the file exists 
 *
 * @param String $file_name
 * @param String $filesystem_storage_root
 * @return Object
*/
function verify_file_existence($file_name = null, $filesystem_storage_root = null)
{
    if (is_it_null_or_empty($file_name) || is_it_null_or_empty($filesystem_storage_root))
    { return ['result' => 'error', 'message' => 'Make sure you are sending both parameters (file name and root filesystem) correctly.']; }

    if (is_it_null_or_empty(config('filesystems.disks')[$filesystem_storage_root]))
    { return ['result' => 'error', 'message' => 'Root filesystem do not exist.']; }

    try {
        $exists = Storage::disk($filesystem_storage_root)->exists($file_name);
        return ['result' => $exists];
    } catch (\Exception $exception) {
        Log::info($eexception->getMessage());
        return [
            'result'  => 'error',
            'message' => $exception->getMessage(),
        ]; 
    }
}


/**
 * Delete File
 *
 * @param String $file_name
 * @param String $filesystem_storage_root
 * @return Object
*/
function delete_file($file_name = null, $filesystem_storage_root = null)
{
    if (is_it_null_or_empty($file_name) || is_it_null_or_empty($filesystem_storage_root))
    { return ['result'  => false, 'message' => 'Make sure you are sending both parameters (file and root filesystem) correctly.']; }

    if (is_it_null_or_empty(config('filesystems.disks')[$filesystem_storage_root]))
    { return ['result'  => false, 'message' => 'Root filesystem do not exist.']; }

    try {
        Storage::disk($filesystem_storage_root)->delete($file_name);
        return ['result' => true];
    } catch (\Exception $exception) {
        Log::info($eexception->getMessage());
        return [
            'result'  => false,
            'message' => $exception->getMessage(),
        ]; 
    }
}