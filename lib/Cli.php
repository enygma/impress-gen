<?php

namespace ImpressGen\Lib;

class Cli
{
    /**
     * Allowed options
     * @var array
     */
    private $_optionsList = array(
        'short' => array(
        ),
        'long'  => array(
            'output::',
            'source::',
            'help::'
        )
    );

    /**
     * Option descriptions
     * @var array
     */
    private $_optionDesc = array(
        'output' => 'Output file (.html) to write presentation to',
        'source' => 'Source directory to find slide/markdown files in',
        'help'   => 'This help message'
    );

    /**
     * User-provided options
     * @var array
     */
    private $_userOptions = array();

    /**
     * Handle the options the user has provided
     *
     * @return void
     */
    public function handle()
    {
        // handle the command line options
        $options = getopt(
            implode('',$this->_optionsList['short']),
            $this->_optionsList['long']
        );

        $this->_userOptions = $options;
    }

    /**
     * Find the option in our list. If it doesn't exist, return null
     *
     * @param string $optionName Option name
     *
     * @return string Option value or null
     */
    public function getOption($optionName)
    {
        return (isset($this->_userOptions[$optionName])) ? $this->_userOptions[$optionName] : null;
    }

    /**
     * Special case - show the help information for the tool
     *
     * @return void
     */
    public function displayHelp()
    {
        echo "\n## impress-gen help:\n";

        // find longest array key
        $map = array_map('strlen', array_keys($this->_optionDesc));
        asort($map,SORT_ASC);
        $maxLength = array_pop($map);

        foreach ($this->_optionDesc as $flag => $desc) {
            echo str_pad($flag,$maxLength+1,' ',STR_PAD_RIGHT)." : ".$desc."\n";
        }
        echo "\n";
    }
}

?>
