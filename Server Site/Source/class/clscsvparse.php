<?
class csvparser
{
    private $fp; 
    private $parse_header; 
    private $header; 
    private $delimiter; 
    private $length; 
    //-------------------------------------------------------------------- 
    function __construct($file_name, $parse_header=false, $delimiter="\t", $length=8000) 
    { 
        $this->fp = fopen($file_name, "r"); 
        $this->parse_header = $parse_header; 
        $this->delimiter = $delimiter; 
        $this->length = $length; 
        $this->lines = $lines; 

        if ($this->parse_header) 
        { 
           $this->header = fgetcsv($this->fp, $this->length, $this->delimiter); 
        } 

    } 
    //-------------------------------------------------------------------- 
    function __destruct() 
    { 
        if ($this->fp) 
        { 
            fclose($this->fp); 
        } 
    } 
    //-------------------------------------------------------------------- 
    function get($max_lines=0) 
    { 
        //if $max_lines is set to 0, then get all the data 

        $data = array(); 

        if ($max_lines > 0) 
            $line_count = 0; 
        else 
            $line_count = -1; // so loop limit is ignored 

        while ($line_count < $max_lines && ($row = fgetcsv($this->fp, $this->length, $this->delimiter)) !== FALSE) 
        { 
            if ($this->parse_header) 
            { 
                foreach ($this->header as $i => $heading_i) 
                { 
                    $row_new[$heading_i] = $row[$i]; 
                } 
                $data[] = $row_new; 
            } 
            else 
            { 
                $data[] = $row; 
            } 

            if ($max_lines > 0) 
                $line_count++; 
        } 
        return $data; 
    } 
    //-------------------------------------------------------------------- 
    function analyse_file($file, $capture_limit_in_kb = 10) {
    // capture starting memory usage
    $output['peak_mem']['start']    = memory_get_peak_usage(true);

    // log the limit how much of the file was sampled (in Kb)
    $output['read_kb']                 = $capture_limit_in_kb;
    
    // read in file
    $fh = fopen($file, 'r');
        $contents = fread($fh, ($capture_limit_in_kb * 1024)); // in KB
    fclose($fh);
    
    // specify allowed field delimiters
    $delimiters = array(
        'comma'     => ',',
        'semicolon' => ';',
        'tab'         => "\t",
        'pipe'         => '|',
        'colon'     => ':'
    );
    
    // specify allowed line endings
    $line_endings = array(
        'rn'         => "\r\n",
        'n'         => "\n",
        'r'         => "\r",
        'nr'         => "\n\r"
    );
    
    // loop and count each line ending instance
    foreach ($line_endings as $key => $value) {
        $line_result[$key] = substr_count($contents, $value);
    }
    
    // sort by largest array value
    asort($line_result);
    
    // log to output array
    $output['line_ending']['results']     = $line_result;
    $output['line_ending']['count']     = end($line_result);
    $output['line_ending']['key']         = key($line_result);
    $output['line_ending']['value']     = $line_endings[$output['line_ending']['key']];
    $lines = explode($output['line_ending']['value'], $contents);
    
    // remove last line of array, as this maybe incomplete?
    array_pop($lines);
    
    // create a string from the legal lines
    $complete_lines = implode(' ', $lines);
    
    // log statistics to output array
    $output['lines']['count']     = count($lines);
    $output['lines']['length']     = strlen($complete_lines);
    
    // loop and count each delimiter instance
    foreach ($delimiters as $delimiter_key => $delimiter) {
        $delimiter_result[$delimiter_key] = substr_count($complete_lines, $delimiter);
    }
    
    // sort by largest array value
    asort($delimiter_result);
    
    // log statistics to output array with largest counts as the value
    $output['delimiter']['results']     = $delimiter_result;
    $output['delimiter']['count']         = end($delimiter_result);
    $output['delimiter']['key']         = key($delimiter_result);
    $output['delimiter']['value']         = $delimiters[$output['delimiter']['key']];
    
    // capture ending memory usage
    $output['peak_mem']['end'] = memory_get_peak_usage(true);
    return $output;
}
}
?>